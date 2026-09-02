CREATE DATABASE IF NOT EXISTS hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hospital_management;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS bill_items;
DROP TABLE IF EXISTS bills;
DROP TABLE IF EXISTS medicines;
DROP TABLE IF EXISTS medical_records;
DROP TABLE IF EXISTS admissions;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS patient_accounts;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','receptionist','doctor') NOT NULL DEFAULT 'receptionist',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  department_name VARCHAR(120) NOT NULL UNIQUE,
  description TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  department_id INT NULL,
  name VARCHAR(120) NOT NULL,
  specialization VARCHAR(120) NULL,
  phone VARCHAR(30) NULL,
  email VARCHAR(150) NULL,
  gender VARCHAR(20) NULL,
  qualification VARCHAR(150) NULL,
  fee DECIMAL(10,2) NOT NULL DEFAULT 0,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  CONSTRAINT fk_doctor_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

CREATE TABLE patients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_code VARCHAR(40) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL,
  gender VARCHAR(20) NULL,
  dob DATE NULL,
  phone VARCHAR(30) NULL,
  email VARCHAR(150) NULL,
  address TEXT NULL,
  blood_group VARCHAR(10) NULL,
  emergency_contact VARCHAR(50) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE patient_accounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_patient_account_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  reason VARCHAR(255) NULL,
  status ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_appt_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
  CONSTRAINT fk_appt_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

CREATE TABLE admissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  room_no VARCHAR(30) NULL,
  bed_no VARCHAR(30) NULL,
  admission_date DATE NOT NULL,
  discharge_date DATE NULL,
  status ENUM('admitted','discharged') NOT NULL DEFAULT 'admitted',
  CONSTRAINT fk_adm_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
  CONSTRAINT fk_adm_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

CREATE TABLE medical_records (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_id INT NULL,
  diagnosis TEXT NULL,
  prescription TEXT NULL,
  notes TEXT NULL,
  record_date DATE NOT NULL,
  CONSTRAINT fk_med_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
  CONSTRAINT fk_med_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
  CONSTRAINT fk_med_appt FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
);

CREATE TABLE medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  medicine_name VARCHAR(150) NOT NULL,
  category VARCHAR(100) NULL,
  unit_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock_qty INT NOT NULL DEFAULT 0,
  expiry_date DATE NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active'
);

CREATE TABLE bills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  bill_date DATE NOT NULL,
  consultation_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  room_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  medicine_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  test_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  other_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  total_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  payment_status ENUM('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  CONSTRAINT fk_bill_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(30) NULL,
  subject VARCHAR(180) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bill_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bill_id INT NOT NULL,
  item_name VARCHAR(160) NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  CONSTRAINT fk_bill_item FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

INSERT INTO departments(department_name,description) VALUES
('General Medicine','General diagnosis and treatment'),
('Cardiology','Heart and cardiovascular care'),
('Orthopedics','Bone and joint care'),
('Pediatrics','Child healthcare');

INSERT INTO doctors(department_id,name,specialization,phone,email,gender,qualification,fee,status) VALUES
(1,'Dr. Aarav Shah','General Physician','9876500001','aarav@example.com','Male','MBBS, MD',500,'active'),
(2,'Dr. Meera Joshi','Cardiologist','9876500002','meera@example.com','Female','MBBS, DM Cardiology',900,'active'),
(3,'Dr. Rohan Patel','Orthopedic Surgeon','9876500003','rohan@example.com','Male','MS Orthopedics',800,'active');

INSERT INTO patients(patient_code,name,gender,dob,phone,email,address,blood_group,emergency_contact) VALUES
('PAT260001','Karan Mehta','Male','1998-05-10','9990011223','karan@example.com','Surat, Gujarat','B+','9990000111'),
('PAT260002','Nisha Desai','Female','1995-11-22','9990011224','nisha@example.com','Surat, Gujarat','O+','9990000112'),
('PAT260003','Ravi Sharma','Male','1989-08-16','9990011225','ravi@example.com','Navsari, Gujarat','A+','9990000113');

INSERT INTO appointments(patient_id,doctor_id,appointment_date,appointment_time,reason,status,notes) VALUES
(1,1,CURDATE(),'10:30:00','Fever and fatigue','confirmed',''),
(2,2,CURDATE(),'12:00:00','Routine heart check','pending',''),
(3,3,DATE_ADD(CURDATE(), INTERVAL 1 DAY),'16:00:00','Knee pain','confirmed','');

INSERT INTO admissions(patient_id,doctor_id,room_no,bed_no,admission_date,status) VALUES
(2,2,'203','B2',CURDATE(),'admitted');

INSERT INTO medicines(medicine_name,category,unit_price,stock_qty,expiry_date,status) VALUES
('Paracetamol 500mg','Tablet',2.50,120,DATE_ADD(CURDATE(), INTERVAL 18 MONTH),'active'),
('Amoxicillin 500mg','Capsule',8.00,8,DATE_ADD(CURDATE(), INTERVAL 10 MONTH),'active'),
('Vitamin D3','Tablet',6.00,45,DATE_ADD(CURDATE(), INTERVAL 20 MONTH),'active');

INSERT INTO bills(patient_id,bill_date,consultation_amount,room_amount,medicine_amount,test_amount,other_amount,total_amount,payment_status) VALUES
(1,CURDATE(),500,0,120,250,0,870,'paid'),
(2,CURDATE(),900,1500,350,600,0,3350,'unpaid');
