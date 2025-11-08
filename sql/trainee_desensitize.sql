-- Data desensitization script for trainee table
-- Purpose: Replace real PII (name, phone, idnum, address) with synthetic values
-- Safety: Deterministic per id (stable across runs), preserves referential integrity

START TRANSACTION;

-- Ensure table exists
-- UPDATE only affects rows that exist in current database after importing training.sql

UPDATE `trainee`
SET
  `name` = CONCAT('姓名', `id`),
  -- Chinese mainland mobile phone: 11 digits, use 13 + 9-digit pseudo-random tail
  `phone` = CONCAT('13', LPAD(FLOOR(RAND(`id`)*1000000000), 9, '0')),
  -- 18-char pseudo ID number: 6-digit area + 8-digit pseudo date + 3-digit sequence + checksum placeholder 'X'
  `idnum` = CONCAT('420323', LPAD(FLOOR(RAND(`id`+1)*100000000), 8, '0'), LPAD(FLOOR(RAND(`id`+2)*1000), 3, '0'), 'X'),
  `address` = CONCAT('地址已脱敏', `id`)
;

COMMIT;

-- Usage: Run after importing the original dataset if you prefer to desensitize in-place
--   mysql -u <user> -p <db> < sql/trainee_desensitize.sql
-- Note: This script is optional; training.sql already contains desensitized values.
