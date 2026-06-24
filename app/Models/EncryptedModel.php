<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * EncryptedModel
 *
 * A base Eloquent model that automatically encrypts all attributes at rest
 * except for columns listed in $encryptionExcluded.
 *
 * Features:
 * - Automatically encrypts values when saving to the database.
 * - Automatically decrypts values when retrieving from the database.
 * - Supports arrays, JSON, strings, and numeric values.
 * - Columns in $encryptionExcluded remain unencrypted (useful for IDs,
 *   timestamps, or fields you want queryable).
 *
 * Usage:
 * 1. Extend this class in any model that requires encryption. For example: Audit model
 *
 *    class Audit extends EncryptedModel
 *    {
 *        protected $table = 'audits';
 *
 *        protected $fillable = ['auditable_id', 'auditable_type', 'action', 'old_values', 'new_values', 'user_id', 'ip_address'];
 *
 *        // Exclude primary key, timestamps, or columns you want queryable
 *        protected $encryptionExcluded = ['id', 'created_at', 'updated_at'];
 *    }
 *
 * 2. Optionally specify $encryptionExcluded in the child model to skip encryption
 *    for specific columns.
 *
 * Notes:
 * - Encrypted fields are not searchable via SQL queries.
 * - Decryption happens automatically when accessing attributes.
 * - Existing records must be re-saved to be encrypted.
 */
class EncryptedModel extends Model
{
    /**
     * Columns to exclude from encryption (optional)
     * Example: ['id', 'created_at', 'updated_at']
     */
    protected $encryptionExcluded = [];

    /**
     * Encrypt values before saving
     */
    public function setAttribute($key, $value)
    {
        if (! in_array($key, $this->encryptionExcluded) && ! is_null($value)) {
            // Convert arrays/objects to JSON, then encrypt
            $value = Crypt::encryptString(json_encode($value));
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Decrypt values when retrieving
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (! in_array($key, $this->encryptionExcluded) && ! is_null($value)) {
            try {
                $decrypted = Crypt::decryptString($value);
                // Try to decode JSON arrays/objects
                $json = json_decode($decrypted, true);

                return $json !== null ? $json : $decrypted;
            } catch (\Exception $e) {
                // If not encrypted or decryption fails, return raw value
                return $value;
            }
        }

        return $value;
    }
}
