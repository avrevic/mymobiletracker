CREATE TABLE "Third_Party_Login" (
  "3rd Party User Id" Integer,
  "Oauth Token" Integer,
  "Oauth user id token" Integer,
  PRIMARY KEY ("3rd Party User Id")
);

CREATE TABLE "users" (
  "Ip Address" Varchar(50),
  "Store Country" Varchar(50),
  "Visit Time" timestamp,
  "User Unique ID" SERIAL,
  "Phone Number" Integer,
  "Email" Varchar(50),
  "Passwords" Varchar(50),
  "3rd Party User Id" Integer,
  "Login Type" Varchar(50),
  "App Id" Varchar(40),
  PRIMARY KEY ("User Unique ID")
);

CREATE TABLE "Apps" (
  "App Url" Varchar(400),
  "App Name " Varchar(400),
  "App Id" Varchar(40),
  "Type " Varchar(40),
  "Domain" Varchar(100),
  PRIMARY KEY ("App Id")
);

CREATE TABLE "IP_Addresses" (
  "Ip Address" Varchar(50),
  "Country" Varchar(50)
);

CREATE INDEX "Pk" ON  "IP_Addresses" ("Ip Address");

CREATE TABLE "App_Events" (
  "Event Id" Integer,
  "Event Name " Varchar(100),
  "User Unique ID" Integer,
  PRIMARY KEY ("Event Id")
);

CREATE TABLE "Device_Info" (
  "Device Id" Integer,
  "User Id" Integer,
  "Login Type" Varchar(50),
  "Device OS" Varchar(50),
  "Device Model " Varchar(50),
  PRIMARY KEY ("Device Id")
);

