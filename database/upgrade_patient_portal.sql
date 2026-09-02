USE hospital_management;
CREATE TABLE IF NOT EXISTS patient_accounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_patient_account_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);
