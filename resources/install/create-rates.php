<?php
require_once __DIR__ . "/functions.php";

$DB = new Db();
use rental\Rental;
$rental = new Rental($dbh);

// SETTINGS
// $rental->new_setting($DB, "test", "ace"); // Add a new setting
// $rental->__set("grace", "1"); // Change an existing setting

// $rental->remove_all_rate_sheet($DB);

// $rental->create_rate_table($DB, $valid_from, $valid_to, $table_name, $cover, $mileage);
// $rental->insert_row$table_name, $vehicle_group, $day_rate_1, $day_rate_2, $day_rate_3, $day_rate_4, $day_rate_5, $liability, $mileage_cost);
/*
$rental->new_setting($DB, "day_rate_1", "3"); // 1-3 days rate group
$rental->new_setting($DB, "day_rate_2", "9"); // 4-9 days rate group
$rental->new_setting($DB, "day_rate_3", "30"); // 10-30 days rate group
$rental->new_setting($DB, "day_rate_4", "31"); // 31 days plus rate group
*/

$rental->create_rate_table($DB, "2020-09-01", "2020-12-10", "rate_sheet_1", "standard", 300);
$rental->insert_row("rate_sheet_1", "RAV3", 306,266,244,219,12105, '2.00');
$rental->insert_row("rate_sheet_1", "RAV4", 334,290,266,239,12105, '2.27');
$rental->insert_row("rate_sheet_1", "RAV5", 383,346,333,290,12105, '2.69');
$rental->insert_row("rate_sheet_1", "RAV6", 533,474,439,396,19167, '2.98');
$rental->insert_row("rate_sheet_1", "RAV18", 672,598,552,499,19167, '3.58');
$rental->insert_row("rate_sheet_1", "RAV13", 1232,1181,1134,1090,19167, '7.16');
$rental->insert_row("rate_sheet_1", "RAV21", 1171,1123,1078,1036,19167, '2.17');
$rental->insert_row("rate_sheet_1", "RAV15", 1134,1087,1044,1004,19167, '7.16');

$rental->create_rate_table($DB, "2020-04-16", "2020-08-31", "rate_sheet_2", "standard", 300);
$rental->insert_row("rate_sheet_2", "RAV3", 291,253,232,209,12105, '2.00');
$rental->insert_row("rate_sheet_2", "RAV4", 318,276,253,228,12105, '2.27');
$rental->insert_row("rate_sheet_2", "RAV5", 364,329,317,276,12105, '2.69');
$rental->insert_row("rate_sheet_2", "RAV6", 507,451,418,377,19167, '2.98');
$rental->insert_row("rate_sheet_2", "RAV18", 639,569,525,475,19167, '3.58');
$rental->insert_row("rate_sheet_2", "RAV13", 1171,1122,1078,1036,19167, '7.16');
$rental->insert_row("rate_sheet_2", "RAV21", 1113,1067,1025,985,19167, '2.17');
$rental->insert_row("rate_sheet_2", "RAV15", 1078,1033,992,954,19167, '7.16');

$rental->create_rate_table($DB, "2020-12-11", "2021-01-02", "rate_sheet_3", "standard", 300);
$rental->insert_row("rate_sheet_3", "RAV3", 383,333,305,274,12105, '2.00');
$rental->insert_row("rate_sheet_3", "RAV4", 418,363,333,299,12105, '2.27');
$rental->insert_row("rate_sheet_3", "RAV5", 479,433,417,363,12105, '2.69');
$rental->insert_row("rate_sheet_3", "RAV6", 667,593,549,495,19167, '2.98');
$rental->insert_row("rate_sheet_3", "RAV18", 840,748,690,624,19167, '3.58');
$rental->insert_row("rate_sheet_3", "RAV13", 1540,1477,1418,1363,19167, '7.16');
$rental->insert_row("rate_sheet_3", "RAV21", 1464,1404,1348,1295,199167, '2.17');
$rental->insert_row("rate_sheet_3", "RAV15", 1418,1359,1305,1255,19167, '7.16');

$rental->create_rate_table($DB, "2021-01-03", "2021-03-31", "rate_sheet_4", "standard", 300);
$rental->insert_row("rate_sheet_4", "RAV3", 325,282,259,233,12105, '2.00');
$rental->insert_row("rate_sheet_4", "RAV4", 355,308,282,254,12105, '2.27');
$rental->insert_row("rate_sheet_4", "RAV5", 406,367,353,308,12105, '2.69');
$rental->insert_row("rate_sheet_4", "RAV6", 565,503,466,420,19167, '2.98');
$rental->insert_row("rate_sheet_4", "RAV18", 713,634,586,529,19167, '3.58');
$rental->insert_row("rate_sheet_4", "RAV13", 1306,1252,1203,1156,19167, '7.16');
$rental->insert_row("rate_sheet_4", "RAV21", 1242,1191,1143,1099,19167, '2.17');
$rental->insert_row("rate_sheet_4", "RAV15", 1203,1153,1107,1065,19167, '7.16');

$rental->create_rate_table($DB, "2020-09-01", "2020-12-10", "rate_sheet_5", "super", 300);
$rental->insert_row("rate_sheet_5", "RAV3", 377,337,316,290,3026, '2.00');
$rental->insert_row("rate_sheet_5", "RAV4", 406,362,337,311,3026, '2.27');
$rental->insert_row("rate_sheet_5", "RAV5", 454,418,405,362,3026, '2.69');
$rental->insert_row("rate_sheet_5", "RAV6", 604,546,509,467,5044, '2.98');
$rental->insert_row("rate_sheet_5", "RAV18", 773,698,653,598,5044, '3.58');
$rental->insert_row("rate_sheet_5", "RAV13", 1333,1282,1234,1190,5044, '7.16');
$rental->insert_row("rate_sheet_5", "RAV21", 1271,1223,1179,1136,5044, '2.17');
$rental->insert_row("rate_sheet_5", "RAV15", 1234,1187,1145,1103,5044, '7.16');

$rental->create_rate_table($DB, "2020-04-16", "2020-08-31", "rate_sheet_6", "super", 300);
$rental->insert_row("rate_sheet_6", "RAV3", 359,321,301,276,3026, '2.00');
$rental->insert_row("rate_sheet_6", "RAV4", 386,344,321,296,3026, '2.27');
$rental->insert_row("rate_sheet_6", "RAV5", 432,398,385,344,3026, '2.69');
$rental->insert_row("rate_sheet_6", "RAV6", 574,519,484,444,5044, '2.98');
$rental->insert_row("rate_sheet_6", "RAV18", 735,664,621,569,5044, '3.58');
$rental->insert_row("rate_sheet_6", "RAV13", 1267,1218,1173,1131,5044, '7.16');
$rental->insert_row("rate_sheet_6", "RAV21", 1208,1162,1121,1080,5044, '2.17');
$rental->insert_row("rate_sheet_6", "RAV15", 1173,1128,1088,1048,5044, '7.16');

$rental->create_rate_table($DB, "2020-12-11", "2021-01-02", "rate_sheet_7", "super", 300);
$rental->insert_row("rate_sheet_7", "RAV3", 472,422,395,363,3026, '2.00');
$rental->insert_row("rate_sheet_7", "RAV4", 508,453,422,389,3026, '2.27');
$rental->insert_row("rate_sheet_7", "RAV5", 568,523,507,453, 3026, '2.69');
$rental->insert_row("rate_sheet_7", "RAV6", 755,683,637,584, 5044, '2.98');
$rental->insert_row("rate_sheet_7", "RAV18", 967,873,817,748, 5044, '3.58');
$rental->insert_row("rate_sheet_7", "RAV13", 1667,1603,1543,1488, 5044, '7.16');
$rental->insert_row("rate_sheet_7", "RAV21", 1589,1529,1474,1420,5044, '2.17');
$rental->insert_row("rate_sheet_7", "RAV15", 1543,1484,1432,1379, 5044, '7.16');

$rental->create_rate_table($DB, "2021-01-03", "2021-03-31", "rate_sheet_8", "super", 300);
$rental->insert_row("rate_sheet_8", "RAV3", 400,358,335,308, 3026, '2.00');
$rental->insert_row("rate_sheet_8", "RAV4", 431,384,358,330, 5044, '2.27');
$rental->insert_row("rate_sheet_8", "RAV5", 482,444,430,384, 5044, '2.69');
$rental->insert_row("rate_sheet_8", "RAV6", 641,579,540,496, 5044, '2.98');
$rental->insert_row("rate_sheet_8", "RAV18", 820,740,693,634, 5044, '3.58');
$rental->insert_row("rate_sheet_8", "RAV13", 1413,1359,1309,1262, 5044, '7.16');
$rental->insert_row("rate_sheet_8", "RAV21", 1348,1297,1250,1205,5044, '2.17');
$rental->insert_row("rate_sheet_8", "RAV15", 1309,1259,1214,1170, 5044, '7.16');

// unlimited km rates
$rental->create_rate_table($DB, "2020-05-01", "2020-10-31", "rate_sheet_9", "super", "unlim");
$rental->insert_row("rate_sheet_9", "RAV1", 323,315,305,0,2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV2", 320,310,301,0, 2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV3", 384,373,363,0, 2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV4", 401,388,377,0, 2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV5", 596,579,561,0, 2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV6", 612,595,577,0, 2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV18", 843,819,793,0, 2000, '0.00');
$rental->insert_row("rate_sheet_9", "RAV13", 1270,1232,1196,0, 4000, '0.00');

$rental->create_rate_table($DB, "2020-11-01", "2020-12-10", "rate_sheet_10", "super", "unlim");
$rental->insert_row("rate_sheet_10", "RAV1", 356,347,335,0,2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV2", 361,350,339,0, 2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV3", 434,421,408,0, 2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV4", 450,437,423,0, 2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV5", 655,636,617,0, 2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV6", 668,649,630,0, 2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV18", 927,900,873,0, 2000, '0.00');
$rental->insert_row("rate_sheet_10", "RAV13", 1429,1386,1345,0, 4000, '0.00');

$rental->create_rate_table($DB, "2021-01-06", "2021-04-30", "rate_sheet_11", "super", "unlim");
$rental->insert_row("rate_sheet_11", "RAV1", 323,315,305,0,2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV2", 320,310,301,0, 2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV3", 384,373,363,0, 2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV4", 401,388,377,0, 2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV5", 596,579,561,0, 2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV6", 612,595,577,0, 2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV18", 843,819,793,0, 2000, '0.00');
$rental->insert_row("rate_sheet_11", "RAV13", 1270,1232,1196,0, 4000, '0.00');

$rental->create_rate_table($DB, "2020-12-11", "2021-01-05", "rate_sheet_12", "super", "unlim");
$rental->insert_row("rate_sheet_12", "RAV1", 551,535,518,0,2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV2", 681,660,641,0, 2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV3", 818,794,771,0, 2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV4", 851,825,800,0, 2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV5", 1013,983,954,0, 2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV6", 948,919,890,0, 2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV18", 1434,1391,1348,0, 2000, '0.00');
$rental->insert_row("rate_sheet_12", "RAV13", 2700,2619,2539,0, 4000, '0.00');

