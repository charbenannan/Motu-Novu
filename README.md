# Motu Novu Task Completion Report

## Introduction
This repository contains the implementation of the assigned task for Motu Novu. The task involved creating three essential entities (Products, Customers, and Orders) and implementing primary CRUD (Create, Read, Update, Delete) operations for each entity. Additionally, it required the establishment of relationships between these entities and the implementation of three distinct user roles.

## Task Implementation

### 1. Three Important Entities
- **Products:** CRUD operations for products have been successfully implemented.
- **Customers:** CRUD operations for customers have been successfully implemented.
- **Orders:** CRUD operations for orders have been successfully implemented.

### 2. Relationships
- **Customers -> Orders (One-to-Many):** Customers can create multiple orders, establishing a one-to-many relationship.
- **Orders -> Products (One-to-Many):** Orders can contain multiple products, forming a one-to-many relationship.

### 3. User Roles
The application supports three different user roles:

- **Not Authorized:**
  - Can view the Products List with their details at https://scandiproducts.online/home.php.

- **Logged User:**
  - Can create and view Customers, Orders, and Products, limited to their own account.

- **Manager User:**
  - In addition to the capabilities of a Logged User, they have privileges to edit and delete Customers, Orders, and Products for their own account.

### 4. Authentication and Access Control
- Users are not required to sign in to access basic functionalities such as viewing the Product list and Product details.
- Enhanced access to Customers, Orders, and the ability to create Orders requires users to create an account and sign in.
- Users with Manager roles can only edit and delete the entities they have created.

### 5. Self-Contained Application
- The application is self-contained, requiring no installation on the host machine.
- Users can access the application directly.

## Feedback and Improvements
As a Junior Developer, I welcome feedback and corrections to improve my work and align it with Motu Novu's expectations. My primary goal is to contribute effectively to the team and adhere to established standards and best practices. Any guidance and insights are greatly appreciated.

## Contact
If you have any further questions or require additional information regarding the application or any aspect of the task, please do not hesitate to reach out. Your feedback is invaluable to me, and I am eager to learn and improve.

Thank you for the opportunity to work with Motu Novu, and I look forward to your input.

