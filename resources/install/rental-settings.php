<?php
require_once __DIR__ . "/functions.php";

$DB = new Db();
use rental\Rental;
$rental = new Rental($dbh);

$rental->new_setting("contract_fee", "66", "Contract Fee");
$rental->new_setting("contract_debit_fee", "85", "Contract Fee for Debit Card Rentals");
$rental->new_setting("add_driver", "361", "Additional Driver Fee");
$rental->new_setting("young_driver", "236", "Young Driver Surcharge");
$rental->new_setting("baby_seat", "493", "Baby Seat Cost per rental");
$rental->new_setting("grace", "1", "Grace Period for late returns");

$rental->new_setting("mon_fri_open", "08:00", "Weekdays opening time");
$rental->new_setting("mon_fri_close", "17:00", "Weekdays Closing Time");
$rental->new_setting("sat_open", "08:00", "Saturday opening time");
$rental->new_setting("sat_close", "13:00", "Saturday Closing time");
$rental->new_setting("sun_open", "closed", "Sunday opening time");
$rental->new_setting("sun_close", "closed", "Sunday closing time");

$rental->new_setting("del_col_ohours", "530", "Delivery during office hours");
$rental->new_setting("del_col_ahours", "850", "After Hours Delivery Fee");

$rental->new_setting("tyre_waiver", "41", "Tyre Waiver rate");
$rental->new_setting("gps", "107", "GPS rental rate");
$rental->new_setting("usb_charger", "141", "USB Charger Fee");
$rental->new_setting("accessories_excess", "1500", "Excess Amount for accessories");

$rental->new_setting("fine_handling", "295", "Traffic fine handling Fee");
$rental->new_setting("accident_admin_fee_under", "776", "Admin fee for damages under the threshold");
$rental->new_setting("accident_admin_fee_over", "353", "Admin fee for damages over the threshold");
$rental->new_setting("accident_admin_fee_threshold", "1000", "Admin fee threshold for accident handling fees");

$rental->new_setting("assessors_fee_over", "958", "Assessors Fee for damages over the threshold");
$rental->new_setting("assessors_fee_under", "225", "Assessors Fee for damages under the threshold");
$rental->new_setting("change_over_fee", "410", "Admin fee for changeovers");
$rental->new_setting("refuel_levy", "21", "Levy to refuel a vehicle if over the threshold");
$rental->new_setting("refuel_levy_threshold", "30", "Refuel levy charged if amount is over this threshold");

$rental->new_setting("valet_full", "640", "Cost of a full valet");
$rental->new_setting("valet_half", "320", "Cost of a mini valet");
$rental->new_setting("e_toll", "314", "E-Toll handling fee");
$rental->new_setting("skipped_service", "21", "Skipped service penalty");

$rental->new_setting("rental_deposit", "1500", "Rental Deposit amount for credit card rentals");
$rental->new_setting("rental_debit_deposit", "1750", "Rental Deposit for Debit card rentals");

$rental->fleet_table('RAV3', 't', "Hyundai I10 or similar Manual, Radio/CD, Aircon", "Kia Picanto, Chevrolett Spark");
$rental->fleet_table('RAV4', 'b', "Hyundai I20 or similar Manual, Radio/CD, Aircon", "Renault Sandero, Ford Fiesta");
$rental->fleet_table('RAV5', 'c', "Polo Vivo or similar, Sedan, Manual, Radio/CD, Aircon", "Nissan Almera, Kia Rio");
$rental->fleet_table('RAV6', 'd', "Polo Vivo or similar, Sedan, Automatic, Radio/CD, Aircon", "Nissan Almera, Kia Rio");
$rental->fleet_table('RAV5', 'i', "Toyota Avanza or similar, Manual, 7 seater, Radio/CD, Aircon", "");
$rental->fleet_table('RAV13','e', "Hyundai H1 or Similar, 8 seater mini bus, manual, Aircon", "Mercedes Vito");
$rental->fleet_table('RAV21','e', "Honda Accord Large Automatic Sedan, Automatic, Radio/CD, Aircon", "Honda Accord");
$rental->fleet_table('RAV18', 'y', " Ford Ranger, Two door bakkie with canopy, Radio/CD, Aircon", "Toyota Hilux");