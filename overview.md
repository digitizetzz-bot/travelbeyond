# 📋 Project Overview: Travel Agency Booking System

**Reference Site:** Travel & Beyond (Tanzania)
**Project Type:** Full-Stack Travel Agency & Tour Booking Platform
**Core Business:** Selling curated tour packages (safaris, mountain trekking), hotel accommodations, flight/ferry ticketing, and complete travel itineraries for domestic (Tanzania/Zanzibar) and international destinations.


## Colors
1. #2973c6  Primary
2. #eded00  Secondary
3. #111cf1  Accent


## 1. System Architecture & Tech Stack
*   **Backend & Framework:** Laravel (PHP)
*   **Frontend UI:** Livewire + Tailwind CSS + Alpine.js (TALL Stack)
*   **Admin Panel:** Filament PHP (For rapid CRUD, role management, and booking overviews)
*   **Database:** MySQL / PostgreSQL
*   **Real-time/Cache:** Redis (for session handling and temporary booking locks)

## 2. Core Site Structure (Public Facing)
*   **Home:** Hero search/banner, featured tours (Zanzibar, Kilimanjaro, Serengeti), promotional banners (10-30% off discounts), customer testimonials/Google Reviews widget, and airline partner carousels.
*   **About Us:** Company history, IATA certification details, and team introduction.
*   **Our Services:** Breakdown of offerings (Ticketing, Safari Packages, Hotel Bookings, Ferry Transfers).
*   **Destinations / Tours:** 
    *   Browse by location (Mikumi, Serengeti, Udzungwa, International).
    *   Browse by activity (Trekking, Beach, Wildlife Safari).
*   **Blog / News:** Travel articles and SEO content.
*   **Contact Us:** Inquiry form, physical address (Dar es Salaam), phone numbers, and interactive map.
*   **Authentication:** Customer `Login` and `Sign Up` flows.

## 3. Key Functionalities & Features
*   **Tour & Package Catalog:** Dynamic listings of tours with images, itineraries (Day 1, Day 2, etc.), inclusions/exclusions, pricing (per adult/child), and availability calendars.
*   **Multi-Service Booking Engine:** Users should be able to inquire about or book flights, ferries, hotels, and custom safari packages.
*   **Customer Portal:** A dashboard where logged-in users can view past trips, download tickets, check upcoming itineraries, and communicate with the travel agent.
*   **Review System:** Ability to pull in Google Reviews or allow users to submit testimonials directly on the site.
*   **Newsletter Subscription:** Lead capture form at the footer linking to an email marketing service.
*   **Discount Engine:** Logic to apply percentage-based or flat-rate discounts to specific tours or seasonal promotions.

## 4. Database Entities (Models to Scaffold)
1.  `User` (Role: Admin, Agent, Customer)
2.  `Destination` (e.g., Serengeti, Dubai, Zanzibar)
3.  `Tour` (Belongs to Destination; includes title, description, price, duration)
4.  `TourItinerary` (Belongs to Tour; breakdown of daily activities)
5.  `Booking` (Belongs to User and Tour; includes status: pending, confirmed, cancelled, total amount)
6.  `Service` (Categories like Flights, Hotels, Ferries, Visas)
7.  `Review` (Customer testimonials)
8.  `Article` (For the Blog/News section)
9.  `Partner` (For storing Airline logos and API credentials)

## 5. Third-Party Integrations
*   **Payment Gateway:** Direct integration with local Tanzanian payment providers (e.g., Selcom, DPO Group, or Pesapal) and Mobile Money (M-Pesa, Tigo Pesa, Airtel Money).
*   **Ticketing/Flight APIs:** Amadeus, Sabre, or direct IATA APIs for pulling flight schedules.
*   **Communication:** Email notifications (SMTP/Mailgun) for booking confirmations, and WhatsApp API for instant client updates.

---