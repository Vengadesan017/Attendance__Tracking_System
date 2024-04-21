USE [master]
GO

Create DATABASE [Attendance_System]

GO 

USE [Attendance_System]

GO 

-- Table structure for table Attendance
CREATE TABLE [dbo].[Attendance] (
  [id] BIGINT NOT NULL IDENTITY(2,1),
    [essl_id] int NOT NULL,
  [employee_id] int NOT NULL,
  [a_date] DATE NOT NULL,
  [Shift_id] INT NULL,
  [Attendance] NVARCHAR(255) NULL,
  [a_status] VARCHAR(20) NULL,
  [Status_code] [NVARCHAR](255) NOT NULL,  
  [in_time] time,
  [out_time] time,
  [remarks] VARCHAR(255) NULL,
  [remark_by] VARCHAR(255) NULL,
  [approved_by] VARCHAR(50) NULL,
  [approved_at] DATETIME NULL,
  [verified_by] VARCHAR(50) NULL,
  [verified_at] DATETIME NULL,

  CONSTRAINT [PK_Attendance] PRIMARY KEY CLUSTERED ([essl_id] ASC)
)

-- Table structure for table Contractor
CREATE TABLE [dbo].[Contractor] (
  [Contractor_id] INT NOT NULL,
  [Contractor_name] VARCHAR(50) NOT NULL,
  CONSTRAINT [PK_Contractor] PRIMARY KEY CLUSTERED ([Contractor_id] ASC)
)

CREATE TABLE [dbo].[Department] (
  [department_id] INT NOT NULL IDENTITY(2000,1),
  [department_name] NVARCHAR(100) NOT NULL,
  [user_id] int NULL,
  [division_id] int NULL, 
  CONSTRAINT [PK_Department] PRIMARY KEY CLUSTERED ([department_id] ASC)
)


-- Table structure for table Employee
CREATE TABLE [dbo].[Employee] (
    [e_id] int NOT NULL IDENTITY(2,1),
  [EmployeeCode] NVARCHAR(50) NOT NULL,
  [employee_id] INT NOT NULL,
  [employee_name] NVARCHAR(50) NOT NULL,
  [Gender] NVARCHAR(255) NULL,
  [Father_name] NVARCHAR(255) NULL,
  [Mother_name] NVARCHAR(255) NULL,
  [email] NVARCHAR(255) NULL,
  [salary] INT NULL,
  [Department_id] INT NULL,
  [Section_id] INT NULL,
  [Contractor_id] INT NULL,
  [Category] NVARCHAR(255) NULL,
  [Designation] NVARCHAR(255) NULL,  
  [division_id] INT NULL,
  [DOJ] DATE NULL,
  [DOR] DATE NULL,
  [DOB] DATE NULL,
  [Employee_type] NVARCHAR(255)  NULL, 
  [a_flag] nvarchar(10) NULL,
  [location_id] int NULL,
  [is_working] VARCHAR(255)  NULL,
  [Blood_group] NVARCHAR(255) NULL,
  [Address] NVARCHAR(255) NULL,
  CONSTRAINT [PK_Employee] PRIMARY KEY CLUSTERED ([EmployeeCode] ASC)
)


-- Table structure for table Login
CREATE TABLE [dbo].[Login] (
  [login_id] INT NOT NULL,
  [login_name] VARCHAR(50) NOT NULL,
  CONSTRAINT [PK_Login] PRIMARY KEY CLUSTERED ([login_id] ASC)
)

-- Table structure for table Section
CREATE TABLE [dbo].[Section] (
  [Section_id] INT NOT NULL IDENTITY(3000,1),
  [Section_name] VARCHAR(50) NOT NULL,
  [department_id] int NOT NULL,
  [user_id] int NULL,
  CONSTRAINT [PK_Section] PRIMARY KEY CLUSTERED ([Section_id] ASC)
)

CREATE TABLE [dbo].[Division] (
  [division_id] INT NOT NULL IDENTITY(1000,1),
  [division_name] VARCHAR(50) NOT NULL,
  [location_id] int NULL, 
  CONSTRAINT [PK_Division] PRIMARY KEY CLUSTERED ([division_id] ASC)
)



CREATE TABLE [dbo].[Location] (
  [location_id] INT NOT NULL IDENTITY(500,1),
  [location_name] VARCHAR(50) NOT NULL,
  CONSTRAINT [PK_Location] PRIMARY KEY CLUSTERED ([location_id] ASC)
)


-- Table structure for table Shift
CREATE TABLE [dbo].[Shift] (
  [Shift_id] INT NOT NULL,
  [Shift_name] VARCHAR(10) NOT NULL,
  CONSTRAINT [PK_Shift] PRIMARY KEY CLUSTERED ([Shift_id] ASC)
)

-- Table structure for table User
CREATE TABLE [dbo].[User] (
  [user_id] INT NOT NULL,
  [username] VARCHAR(50) NOT NULL,
  [password] VARCHAR(200) NOT NULL,
  [department] VARCHAR(30) NOT NULL,
  [login_id] INT NOT NULL,
  CONSTRAINT [PK_User] PRIMARY KEY CLUSTERED ([user_id] ASC),
 
)



INSERT INTO [dbo].[User] (user_id,username,password,department,login_id) VALUES(2,'admin','$2y$10$.xEQN2hH/ljgTOcmrLAuv.GyrQXGNiP2QnpkD42bP/8MoTQVJwGH.','admin',4);


INSERT INTO [dbo].[Shift]([Shift_id],[Shift_name])
VALUES 
(1,'WO'),
(2,'FS'),
(3,'NS'),
(4,'H'),
(5,'G'),
(8,'SAM'),
(12,'1'),
(13,'2'),
(14,'3'),
(15,'SC'),
(16,'TT');



INSERT INTO [dbo].[Login] ([login_id], [login_name])
VALUES (1, 'Department'), (2, 'Finance'), (3, 'Contractor'), (4, 'HR');








