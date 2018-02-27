# Contao Newsalert Module
[![Latest Stable Version](https://poser.pugx.org/heimrichhannot/contao-newsalert/v/stable)](https://packagist.org/packages/heimrichhannot/contao-newsalert)
[![Total Downloads](https://poser.pugx.org/heimrichhannot/contao-newsalert/downloads)](https://packagist.org/packages/heimrichhannot/contao-newsalert)

> Contao 3 backport from [Contao Newsalert Bundle](https://github.com/heimrichhannot/contao-newsalert-bundle)

A contao module, to let website visitor subscribe to a news topic.

The module comes with an interface to add custom news topic, for example categories, tags, authors.

## Features
* subscribe form module
* add custom topic sources
* send notifications to user subscribed to topics with notification center
* use contao cron to trigger send
* security features
    * captcha in form field
    * opt-in process after subscribe
    * token secured opt-out links
* dublicate entry check
    * when dublicate entry is not confirmed, resend activation link instead of showing error message
* archive informations about sent messages
* bundled topic source for news archives


## Requirements

* Contao 3.5
* PHP >= 7.0
* [Contao Notification Center](https://github.com/terminal42/contao-notification_center)
* [Formhybrid](https://github.com/heimrichhannot/contao-formhybrid)

## Installation

Install via composer

```
composer require heimrichhannot/contao-newsalert
```

Afterwards call the Contao install procedure to update the database.

## Setup

* add topic sources
* set up notification center notifications
    * `hh_newsalert` for newsalert messages
    * `formhybrid-opt-in` for opt-in mails
* add frontend registration module and configure it
* activate newsalert in news archive you want newsalert for

### Cronjob


For performance reasons, we insist on disabling the "Command-Scheduler" in Settings (enable `tl_settings.disableCron`) and run the cron jobs by a dedicated cronjob within your servers crontab.

Contao 3: 

```
* * * * * wget -O /dev/null -q https://[DOMAIN-NAME]/system/cron/cron.php --no-check-certificate
```

## Usage

The module adds a checkbox to news archive to activate (or deactivate) newsalert for archives. It also add a checkbox to the news articles form to set (or unset) an article sent (by setting unsent newsalert will be triggered again for said article).

The overview about sent messages is placed within the news archive section (News -> Newsalert).
The management of the receivers is found withing the newsalert section (News -> Newsalert -> Newsalert receivers)

## Developers

### Add topic source

To add a topic source, your topics class needs to implement the `NewsTopicInterface` and has to be registered within `$GLOBALS['HUH_NEWSALERT']['TOPIC_SOURCE']`.

Example:

```
$GLOBALS['HUH_NEWSALERT']['TOPIC_SOURCE']['newsarchives'] = \HeimrichHannot\ContaoNewsAlertBundle\Components\NewsArchiveTopics::class;
```

### Notification center tokens
ContaoNewsalert uses Notification Center for e-mail sending. Following tokens are added to `news_posted` type (in addition to the default ones): 

Tag                                   | Description
--------------------------------------|-----------
##huh_newsalert_topic_recipient##      | Emailaddress of the subscriber
##huh_newsalert_news_headline##        | Title of the news for which newsalert is triggered
##huh_newsalert_news_subheadline##     | SUbheadline of the news for which newsalert is triggered
##huh_newsalert_news_teaser##          | Teaser text of the news article
##huh_newsalert_news_content##         | Article content
##huh_newsalert_news_url##             | Relative url to the article
##huh_newsalert_recipient_topics##     | The intersection of news topics and subscribed topics of the receiver
##huh_newsalert_recipient_topic_count##| The the number of topics from ##hh_newsalert_recipient_topics##
##huh_newsalert_opt_out_html##         | A list of all recipients topics and the corresponding unsubscribe links in html format (Topic: Link)
##huh_newsalert_opt_out_text##         | Same list as above, but textonly
##huh_newsalert_year##                 | The current year
##huh_newsalert_root_url##             | Root url

### Hooks

Name                     | Arguments                                            | Expected return value | Description
-------------------------|------------------------------------------------------|-----------------------|------------
huh_newsalert_customToken |NewsModel $objArticle, array $arrTokens, DC_Table $dc | $arrTokens            | Hook to add custom tokens or manipulate existing ones. Don't forget to register them via your config.php file.

### Frontend autocompletion
We recommend [Chosen](https://harvesthq.github.io/chosen/) to add a search field to the topic select element. It's already used by Contao in the backend.