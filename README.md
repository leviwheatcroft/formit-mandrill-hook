## Mandrill Hook for MODx FormIt

Mandrill is an email service, it can be used to send email via an api rather than sending email directly from your web server. This hook is a pretty simple alternative to the built in FormIt email hook.

## usage

1. get a mandrill api key

    head over to [mandrill.com][2] and get yourself an API key. There's a very generous free usage tier.

2. get the mandrill class

    Clone the mandrill class from [the bitbucket repo][1] into `assets/php/mandrill` or so.

3. make the snippet

    Create a snippet called `sendMandrill` or whatever with the contents of `sendMandrill.php` from this repo.

4. change your formIt call

    like this:

        [[!FormIt?
          &hooks=`sendMandrill,redirect`
          &mandrillApiKey=`d9MTDMVKVMhbH7_eCbUQtA`
          &emailTpl=`contactTpl`
          &subject=`email from somewebsite.com`
          &emailTo=`levi@someaddress.com`
          &emailToName=`Levi Wheatcroft`
          &redirectTo=`60`
          &validate=`name:required,
            email:email:required,
            message:required:stripTags`
        ]]

[1]: https://bitbucket.org/mailchimp/mandrill-api-php/src "mandrill-api-php"
[2]: http://mandrill.com/pricing/ "mandrill pricing"

