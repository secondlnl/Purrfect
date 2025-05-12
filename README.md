# Purrfect

- [Purrfect](#purrfect)
  - [Introduction](#introduction)
    - [Why? / Rational](#why--rational)
  - [Features](#features)
  - [Database instantiation](#database-instantiation)

## Introduction

A high school gradutation web project, E-commerence site.

### Why? / Rational

Other than being a fun project, it also in my view fills a hole in the current market of e-commerence sites being the overwelming issue of advertisments and of invasive popups.

## Features

WIP

## Database instantiation
Needed (Ensure these tools and utilies are installed before going forward)
* A MySQL or equivalent server

### About the connection
The database is connected to the program using ``` config.php ```, at the top **Updated on 05-12-2025**
```php
// Declaire constants for quote, endquote Portability
define("_SERVERADDRESS", "Localhost");
define("_SERVERUSER", "root");
define("_SERVERPASS", "");
define("_DBNAME", "PURRFECTDB01");
```
The only ones you would need to touch is the last three, setting up the server user, password and the database used **(If you use a different db name, change this one if you want it to work.)**.

### Create the db
Create your database with whatever name you like, I do not care but maybe something funny or not like **bananabread**. 
```MySql 
Create table purrfectdb01
```

### Making the tables
*Accounts*
```MySql
CREATE TABLE `Accounts` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `Seller` int(1) NOT NULL DEFAULT 0
);
```
*Comments*
```MySql
CREATE TABLE `Comments` (
  `ID` int(255) NOT NULL,
  `PID` int(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `Date` varchar(255) NOT NULL
);
```
*Orders*
```MySql
CREATE TABLE `Orders` (
  `OrderID` int(255) NOT NULL,
  `UserID` int(255) NOT NULL,
  `Date` varchar(255) NOT NULL,
  `Products` varchar(255) NOT NULL
);
```
*Products*
```MySql
CREATE TABLE `Products` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Rating` int(255) NOT NULL DEFAULT 0,
  `Ratedby` varchar(255) NOT NULL,
  `SellerID` int(255) NOT NULL
);
```
*Purchases*
```MySql
CREATE TABLE `Purchases` (
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL
);
```
and if you want to get all fancy

*Accounts*
```Mysql
ALTER TABLE `Accounts`
  ADD PRIMARY KEY (`ID`);

```
*Comments*
```mysql
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`ID`);

```
*Orders*
```mysql
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderID`);

```
*Products*
```mysql
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ID`);

```
*Accounts* (again) 
```mysql
ALTER TABLE `Accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

```
*Comments* (again)
```mysql
ALTER TABLE `Comments`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT;
```
*Orders* (again)
```mysql
ALTER TABLE `Orders`
  MODIFY `OrderID` int(255) NOT NULL AUTO_INCREMENT;
```
*Products* (again)
```mysql
ALTER TABLE `Products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
```
Maybe done.
### Bonus
Congrats if you have made it this far, do you find your products a little empty and lonely like "Hey! Where are all my products". Well fear not for I have the fix, simply take this code and add some pretty sweet products if I say so myself.
```MySql
INSERT INTO `Products` (`ID`, `Name`, `Description`, `Price`, `Rating`, `Ratedby`, `SellerID`) VALUES
(1, 'Box', 'A box for your beautiful kittens', 25, 1, '', 0),
(2, 'Fur-tastic Groomer', 'A versatile grooming kit that includes a deshedding brush, nail clippers, and a grooming glove. Perfect for keeping your cat\'s coat smooth and shiny while reducing shedding.', 26, 1, '', 0),
(3, 'Purrfect Nap Bed\r\n', 'A plush, orthopedic bed designed to provide maximum comfort and support for cats of all ages. The removable, washable cover ensures easy maintenance.', 40, 2, '', 0),
(5, 'Hydro-Paws Fountain', 'A pet water fountain with a charcoal filter that provides fresh, clean water to encourage your cat to stay hydrated. The continuous flow prevents stagnant water.\r\n', 35, 2, '', 0),
(6, 'Catnip Carnival Toys', 'A set of five different catnip-infused toys, including balls, mice, and a scratching pad, designed to keep your cat entertained and active.', 20, 1, '', 0),
(7, 'Litter-ally Clean Box', 'A self-cleaning litter box with an odor control system. The enclosed design ensures privacy for your cat while keeping your home fresh.\r\n', 130, 0, '', 0),
(9, 'Purrfect Health Vitamins', 'A comprehensive supplement powder with essential vitamins and minerals to support your cat’s overall health, from coat shine to joint support.', 15, 0, '', 0),
(10, 'Feline Fun Laser', 'An automatic laser pointer with adjustable settings to keep your cat active and entertained even when you’re not home. Promotes exercise and mental stimulation.\r\n', 30, 0, '', 0);
```
Oki, now you are done! *clap* *clap* (Maybe time for popcorn! Or wait you should probably actually do these before that so you do not grease down your keyboard)
