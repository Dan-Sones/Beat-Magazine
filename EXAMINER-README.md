# Upgrading Account

BeatMagazine features two account levels, Community-User and Journalist

- Community-User: Standard account, permissions granted when the user registers
- Journalist: Account with additional permissions to Create Albums, artists and Journalist reviews.

To upgrade an existing Community-User account to a journalist account, visit the /upgrade page and enter
the value of the variable *UPGRADE_PASSWORD* as found in the .env file.
This will upgrade the account to a Journalist account and grant the user additional permissions.

In a fully fledged version of BeatMagazine.com, should be facilitated through an administrative portal.

# Known Issues

- Reset Password
    - There is a common issue with the reset password feature, where the user will press the _forgot password?_ button
      but recieve no success or fail message for approx 20 seconds.
        - This is due to an issue with the 34sp SMTP server which seems to need approx 20-30 seconds wake up when a
          request is sent. Faster speeds are only included in the Private SMTP 34sp paid plan.
            - To use this functionality unfortunately the user will have to wait 20-30 seconds before the success or
              fail
              message is displayed.