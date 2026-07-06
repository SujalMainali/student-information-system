# Student Information System (SIS)

A Laravel-based Student Information System built with custom API token authentication, role-based authorization, and modular backend features for managing students, courses, enrollments, schedules, and academic records.

## Overview

This project is being developed as a scalable Student Information System for educational institutions. The current codebase already includes a working backend foundation with:

* Custom API token authentication
* Role-based authorization
* Student and course management
* Enrollment relationships
* API Resources
* Form Requests
* Policies
* Role middleware

The long-term goal is to evolve the application into a complete role-aware SIS with dedicated workflows for administrators, staff, and students.

## Current Features

### Authentication

* Custom API token-based authentication
* Role-aware access control
* Middleware-protected API routes

### Core Data Management

* User management
* Student records
* Course records
* Enrollment relationships between students and courses

### Authorization

* Role-based middleware
* Policies for model-level access control
* Controller authorization using the Gate facade

### API Structure

* REST-style API endpoints
* API Resources for consistent JSON responses
* Form Requests for validation

## Planned Roles

The system is designed around three main user roles:

### Administrator

Responsible for:

* Managing users
* Managing roles
* Managing courses
* Assigning staff to courses
* Approving enrollment requests
* Viewing schedules
* Generating reports

### Staff

Responsible for:

* Managing assigned courses
* Managing schedules
* Creating examinations
* Recording student scores
* Viewing student progress
* Handling academic operations

### Student

Responsible for:

* Browsing available courses
* Requesting enrollment
* Viewing timetable
* Viewing examination results
* Tracking academic progress
* Checking enrollment status

## Planned Functional Modules

### Authentication and Role Management

Each user type will have a dedicated login flow:

* `/login` for students
* `/staff/login` for staff
* `/admin/login` for administrators

These login flows will authenticate the user, validate the role, and issue API access tokens.

### Course Browsing

Students will have a dedicated course browsing experience separate from the admin course management pages. Course listings will show:

* Course code
* Course name
* Credits
* Available seats
* Instructor
* Prerequisites
* Enrollment action

### Enrollment Workflow

Students will request enrollment rather than enrolling automatically. Requests will move through a review workflow:

* Pending
* Approved
* Rejected
* Cancelled

### Enrollment Validation

Enrollment requests will be validated using business rules such as:

* Minimum and maximum credit limits
* Duplicate request prevention
* Existing enrollment checks
* Prerequisite validation
* Course capacity checks
* Enrollment period checks
* Completed course checks

### Timetable and Class Schedule

The system will maintain structured schedules including:

* Day
* Time
* Room
* Session type

Separate timetable views will be provided for:

* Students
* Staff
* Administrators

### Examination Module

Staff will be able to create examinations with:

* Title
* Date
* Duration
* Room
* Weight

Students will be able to view upcoming examinations.

### Student Scores and Performance

Staff will be able to enter:

* Marks
* Grades
* Remarks

Students will be able to view:

* Results
* Feedback
* GPA
* Completed and current credits
* Passed and failed courses
* Academic progress

### Audit Logging

Administrative actions will be tracked for accountability, including:

* User action
* Entity affected
* Timestamp
* Change history

## API Direction

The project will continue moving toward a modular API-first structure with separate endpoints for:

* Authentication
* Student operations
* Staff operations
* Administrator operations
* Dashboards
* Enrollment requests
* Schedules
* Scores
* Course browsing

## Technology Stack

* Laravel
* PHP
* Eloquent ORM
* Custom API authentication
* Role middleware
* Policies
* Form Requests
* API Resources

## Project Status

This project is in active development. The current backend foundation is functional and ready for expansion into a complete Student Information System.

## Future Vision

The final system aims to become a well-structured, role-based academic management platform that supports:

* Secure authentication
* Clean API design
* Strong authorization
* Student self-service features
* Staff academic workflows
* Administrative oversight
* Scalable feature expansion

## Notes

This project is being developed progressively, so current functionality will remain stable while new API-based features are added over time.
