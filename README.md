# Laravel Appointments
## Data modeling

This repository contains the source code for the Laravel Appointments application.

- The application has the following entities:
    - Business
    - Slot
    - User
    - Booking
    - Schedule

## Features
- This project contains the following features:
  - **Business & Schedules:** defining opening/closing hours and specifying the days available.
  - **Booking Slot Generation:** command to generate slots for a business based on their schedules.
  - **User credits:** a credit system for users, allowing them to book slots if they have enough credits.
  - **Booking and Cancellation functionality:** users will be able to book and cancel slots.
  - **Booking Display:** interface for users to view their bookings and cancel them if they are allowed.
  - **Display of available slots:** users can view available slots by filtering by year, month, day and business.

## Tools used
- Laravel 11
- Laravel Sail
- Laravel Breeze
- Laravel Vite
- Traits
- Casts
- Commands
- Seeders
- Migrations
- Controllers

## Commands
- Execute the following commands to generate slots for all businesses:
  - `php/sail artisan app:generate-business-slots` 
