# Changelog

## [0.4.2] - 2018-03-09

#### Fixed
* module page selection not visible in subscripe module config

## [0.4.1] - 2018-03-09

#### Fixed
* lang file sometimes not loaded in redirect module

#### Changed
* removed some contao 4 leftovers

## [0.4.0] - 2018-03-08

#### Fixed
* sql for `newsalert_activate` in `tl_news_archive`

#### Added
* complete english translation for `tl_module`
* translation for `newsalertNoTopicSelection` in `tl_module`

## [0.3.1] - 2018-03-05

#### Fixed
* method call

## [0.3.0] - 2018-03-05

#### Added
* generate opt-out token for recipients without opt-out token (for example after switching from not opt-out to opt-out)
* module page form field, used for opt-out link

#### Changed
* restructured some code in newsalert listener

#### Fixed
* error in backend due usage of Contao 4 only method

## [0.2.2] - 2018-03-01

#### Fixed
* opt-in mail not send

## [0.2.1] - 2018-02-28

#### Fixed
* formhybrid dependency

## [0.2] - 2018-02-28

#### Added
* `huh_newsalert_news_enclosure_html` and `huh_newsalert_news_enclosure_text` notification center tokens
* more settings to registration module
* formhybrid 2.x support

## [0.1] - 2018-02-26
Backported from contao 4

#### Added
* option to open registration only for single topic (Module)

#### Changed
* topic registration with globals
* removed onSubmit callback and custom cron

#### Fixed
* translations
* a lot backend cleaning