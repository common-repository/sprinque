=== Sprinque ===

Contributors: Sprinque
Tags: B2B payments, B2B BNPL, net payment terms
Requires at least: 3.5.0
Tested up to: 6.3.1
Requires PHP: 5.3
Stable tag: 1.14.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sprinque Payments - demand payments by company

== Description ==
No admin. No hassle. No risk.
Sprinque for WordPress is a plugin that allows you to offer your business buyers net payment terms (15, 30, 60, 90 days) and thereby grow conversion and retention. Business buyers can select to pay by invoice and pay up to 90 days later, while you get paid instantly and without incurring additional risk.
Built to integrate seamlessly with your WordPress webshop, Sprinque will appear in the checkout as a payment method for business buyers. When business buyers choose to pay by invoice, Sprinque conducts a real-time fraud and risk assessment. Approved buyers will be given a credit limit and payment term, which can be used for multiple purchases. This will increase conversion and incentivize business buyers to return.
Sprinque also offers your buyers convenient ways to pay for their invoices, when payment is due. We are exclusively focused on payment services for B2B transactions with the sole purpose of helping businesses grow safely in a digital world.

== Beyond a standard payment method ==
Sprinque is on a mission to help businesses grow safely in a digital world. With our fraud and risk engine, we’re able to safely assign a net payment term to new and existing buyers online - all in real time and without adding friction to the buyer.
Business buyers are used to getting payment terms in the offline world and by leveraging this practice in your webshop, you’ll be able to convert more business buyers and increase retention.
Our automatic and real-time assessment replaces manual and time-consuming fraud and credit risk assessment, reducing operational and financial complexity. In order to extend payment terms to your business buyers, you don’t need to become a credit risk specialist, we’ll take care of this.
Sprinque takes away the risk of late payments and defaults for all payments we’ve approved. By paying you instantly when receiving the final invoice via API, we take away the risk of extending payment terms and improve your cash flow.
Visit our website [sprinque.com](https://sprinque.com) for more information or mail to [support@sprinque.com](mailto:support@sprinque.com)

== Screenshots ==
1. Enter billing details of the buyer.
2. Buyer selects and pays with pay by invoice, provided by Sprinque.
3. Buyer enters registration details.
4. Sprinque verifies the email address of the buyer.
5. Real time verification of the buyer's account.
6. Order is successfully confirmed.
7. Sprinque sends white-label payment reminders to the buyer.

== Installation ==
1. In your admin panel, go to Plugins > Add New.
2. Click Upload Plugin and Choose File, then select the plugin’s .zip file.
3. Click Install Now.
4. Click Activate to use your new plugin right away.

== Want to learn more? Get in touch ==
Contact us via [support@sprinque.com](mailto:support@sprinque.com) or visit [our website](https://www.sprinque.com/ "https://www.sprinque.com/").

== Frequently Asked Questions ==

= How configure Sprinque Payments?

Go to WooCommerce > Settings > Payments and select "Pay by Invoice" payment method. Insert your API Key and save changes!

== Changelog ==
= 1.14.1 - June 19, 2024 =
* fix: prevent error when metadata is empty;

= 1.14.0 - June 13, 2024 =
* feat: new search options text for select your business on modal open;
* fix: deprecated warnings;
* fix: translations via AJAX;
* chore: improve performance for get_invoice_number method;

= 1.13.0 - May 21, 2024 =
* feat: Fingerprint in the auth call;
* fix: validate root form before opening Sprinque modal;
* fix: improved scenario for rejected buyer;
* chore: abort webhook if buyer is rejected;
* chore: don't send auth call if buyer is rejected;
* chore: updated layout of step 1;

= 1.12.0 - April 5, 2024 =
* feat: manage FullStory on the Sprinque side;
* feat: improved the available credit limit screen;
* feat: change text and logic of the business not found;
* fix: hide buttons on the otp step;
* fix: notranslate fix;

= 1.11.1 - March 7, 2024 =
* fix: made upload file just for Sprinque payment method;
* fix: adjusted translations;

= 1.11.0 - March 4, 2024 =
* feat: improve passing the merchant invoice id;
* feat: use file_id instead of the pdf link;
* feat: new screen when credit is not sufficient;
* feat: privacy policy checkbox;
* feat: proxy payment collections endpoing;
* fix: mobile buttons styles;
* fix: translation of the "prev" and "next" on OTP;
* fix: what is sprinque for NL;
* fix: light or dark logo in the checkout;
* fix: some localizations are not translated;

= 1.10.0 - February 2, 2024 =
* hotfix: prevent calls that can cause site failure, get data from cache (countries and get seller requests);
* feat: manage Sprinque logo from admin;
* feat: pay in X days from the admin panel;
* chore: fixed what is Sprinque modal;
* chore: changed buttons layout on verify OTP step;
* fix: translation of the "days" word;
* fix: improved FullStory events;

= 1.9.0 - December 5, 2023 =
* feat: what is Sprinque modal;
* Fixed error handler to prevent Sprinque flow;
* Fixed single payment term translation;
* Round invoice amount and initial_order_amount;
* Fixed plugin's translation for de site;
* feat: added merchant's logo to the modal;
* feat: powered by Sprinque and plugin version;
* feat: user tracking events;

= 1.8.0 - November 13, 2023 =
* Payment terms to be displayed with % value;
* Disable reg number if the business is selected from search;
* Prevent API calls if there is no API key in settings;
* Prevent duplicate of net terms options;
* Email validation before sending POST to /buyers;
* Added support for nl_NL and nl language locale;
* Updated payment name and description for admin panel;
* Added additional properties to the fee;
* Added ""%s days" language string;
* Added Portuguese language;

= 1.7.1 - October 24, 2023 =
* Add correct check for `wc_order_item_fee` object.

= 1.7.0 - October 23, 2023 =
* Implemented Fingerprint;
* Pay in 3 instalments;
* Handle wp error for get payment terms;

= 1.6.1 - October 4, 2023 =
* Fixed scenario when business address is not returned from search;

= 1.6.0 - October 3, 2023 =
* Loading screen after the order is placed before the redirect;
* Added initial order amount and currency;
* Fix for word "Free" in translations;
* Fixed showing business address in the list with multiple commas;
* Added function for generate invoice with direct file access;
* Updated post meta to WC_Date meta date;
* Added logic if order is vat exempt then fee tax status going to none;
* Added function for checking fees on the order list;

= 1.5.0 - September 20, 2023 =
* Net terms translations;
* Fixed translation "Your account has been created, and you’ve been approved for a payment term of";
* Changed color for resend OTP code button;
* Block t-online.de emails;
* Warning screen for gmail emails;

= 1.4.0 - September 12, 2023 =
* Set Sprinque payment method description from settings;

= 1.3.10 - August 23, 2023 =
* Bumped b2b-sprinque-tools to v.1.5.0 (with IT, PT, UK reg number warnings);
* Added Italian language (auto-translated);
* Fixed house number of the shipping address;
* Style fixes and improvements;
* Renamed surcharge fee and prevent duplicating it;

= 1.3.9 - August 10, 2023 =
* Fixed checkout_error;

= 1.3.8 - August 1, 2023 =
* Multiple currencies support;
* Fixed initial shipping address not to break the buyer call;
* Added house number to initial shipping address;
* Style improvements;
* Updated b2b-sprinque-tools to v.1.4.2;

= 1.3.7 - July 13, 2023 =
* Don't pass reg number if it's empty;
* Updated translations;

= 1.3.6 - June 29, 2023 =
* Deleted session_cache_limiter('public') in requests;
* Verified Polish translations;
* Used b2b-sprinque-tools for local errors translations;
* Pass business buyer name to metadata for auth call;
* Bumped b2b-sprinque-tools to v.1.3.6;

= 1.3.5 - June 7, 2023 =
* Deleted session_cache_limiter('public') in SprinqueInitialize;

= 1.3.4 - June 1, 2023 =
* Fixed reg number validation (b2b-sprinque-tools v.1.3.2);

= 1.3.3 - May 31, 2023 =
* Patched translations (sprinque.po);

= 1.3.2 - May 31, 2023 =
* Check if order_status array key is set before reading;
* Updated reg number validation (b2b-sprinque-tools v.1.3.1);
* Sending email as lowerCase value, patched issued_by;
* Adding Polish language support;
* Added billing or accounts payable optional email;
* Improved webhook response and handled failures;

= 1.3.1 - May 2, 2023 =
* Round order_amount to 2 decimals;
* Reg number required condition;
* Remove ' ', '/', '-' in phone number;
* Changed top position of the modal;

= 1.3.0 - April 25, 2023 =
* Passing Sprinque fee to buyers;
* Registration number warnings;
* Remove spaces in buyer phone;
* Updated "Company not found" styles and made it clickable;

= 1.2.7 - March 8, 2023 =
* Don't save to cache if get countries call failed;
* Patched translations for otp code timer;

= 1.2.6 - February 22, 2023 =
* Send buyer language only for Belgium (rest Sprinque will handle based on country);
* Fixed how locales are used in translations;
* Capture retry after some time;
* Deleted unused cancel order logic;
* Expose payment option for countries supported by Sprinque;
* Added initial_shipping_address for buyer onboarding;

= 1.2.5 - February 11, 2023 =
* Display error for the inactive buyers;
* Fullstory to be managed from the admin panel (disabled by default);
* Disable resend otp code for 30 sec;
* Show api error on the address screen;
* Align the plugin more to the design;
* Handle empty address from the search;
* Updated .mo files and cleanup unused translations;
* Handle unauthorized api token case (show error);

= 1.2.4 - January 26, 2023 =
* Deleted custom woocommerce_checkout_update_order_review, save_checkout_fields;
  setCustomerBillingData and setCustomerShippingData functions;
* Improved translations that are used in async way;
* Applied styles only on the checkout page;
* Added the credit_bureau_id to POST buyers;
* Validate the root form before opening the modal;
* Added language to POST /buyers (included French);

= 1.2.3 - January 23, 2023 =
* Fixed save-checkout-fields-issue;
* Block search for less than 2 characters;
* The API errors have been displayed;
* Search to be executed when the country is changed;
* Edit email in the root form is reflected in the sprinque otp;
* Delete unused legacy search/business/details;
* Fixed vat-id related .po and .pot translations;
* Improved the search checkbox quality;
* Turned off the fullstory;
* Used PLUGIN_SRINQUE_VERSION for styles and js;

= 1.2.2 - January 17, 2023 =
* Hide add buyer manually block and error message on change;

= 1.2.1 - January 13, 2023 =
* Translated all auth failed messages
* Extended search with search by VAT ID
* Added buyer user language
* Fixed multiple auth calls and prevent auth declined
* Prevent otp code button duplicate clicks
* Hide add buyer manually block (used as search option)
* Moved css to sass (fixed missing new compiled styles)
* Show payment option for Austrian company (AT);

= 1.2.0 - December 29, 2022 =
* Linked DE site locales to plugins existing DE locale
* Improved IPs
* Added "not found" option to top of business search
* Added admin request retries
* Translated more auth declined messages

= 1.1.9 - December 19, 2022 =
* Prevent multiple auth calls
* Limit height of the search results
* Translated auth credit exceeded error
* Enable as payment option for Germany
* Failed order status when buyer is rejected
* Add PHP 8.1.12 support

= 1.1.8 - December 5, 2022 =
* Fixed session cache usage
* Manage payment option name from admin
* Added buyer's phone
* Added tracking code (fullstory.com)
* Order cancellation

= 1.1.7 - November 10, 2022 =
* Fixed plugins valid header

= 1.1.6 - November 10, 2022 =
* Renamed title of the payment method

= 1.1.5 - November 10, 2022 =
* Changed title of the payment method

= 1.1.4 - November 1, 2022 =
* Sync with Phrase and improved translations
* Fixed possibly missing orders
* Removed search/business/details call
* Improvements of the email validation for the right keyboard tab

= 1.1.3 - September 29, 2022 =
* Performance and code improvements
* Fix missing orders with B2C

= 1.1.2 - September 12, 2022 =
* Send correct order id to Sprinque
* Hide validation error until search return company address
* Fixed translation

= 1.1.1 - September 6, 2022 =
* Replaced $order->ID with $order->get_id()
* Hide cancel order button

= 1.1.0 - September 5, 2022 =
* Exposed /wp-json/sprinque/v1/seller/payment-collection-account endpoint

= 1.0.7 - August 31, 2022 =
* Updated logic around place order button
* Added order ID prefix (actually postfix)
* Updated docs and translations
* Improved plugin speed (way translations are applied)

= 1.0.6 - August 26, 2022 =
* Fixed issues when a webhook trigger multiple awaiting orders
* Fixed issue when validating email modal appear redundantly
* Improved translations

= 1.0.5 - August 23, 2022 =
* Improved translations

= 1.0.4 - August 23, 2022 =
* Add Payment Title Localization and Description

= 1.0.3 - August 23, 2022 =
* Fixed search

= 1.0.2 - August 06, 2022 =
* Add German and Dutch localization

= 1.0.0 - July 29, 2022 =
* Initial release
