# Forex Back Office

## About Forex Trading System
This system works with MT5 API

### User Menu & Route

| Menu                                           | Routes                                 | Status               |
| ---------------------------------------------- | -------------------------------------- | -------------------- |
| Profile                                        |                                        |                      |
|  - My Profile                                  | profile                                | :white_large_square: |
|  - Edit Profile                                | profile/edit                           | :white_large_square: |
|  - Change Passwrod                             | profile/change-password                | :white_large_square: |
| Clients                                        | clients                                | :white_check_mark: |
| IB Clients                                     | ib-clients                             | :white_large_square: |
| IB Referrals                                   | ib-referrals                           | :white_large_square: |
| Transactions                                   | transactions                           | :white_large_square: |
|  - Account Ledger                              | transactions/account-ledger            | :white_large_square: |
|  - Internal Transfers                          | transactions/internal-transfers        | :white_large_square: |
| Payment Wallets                                | payment-wallets                        | :white_large_square: |
| MT5 Groups                                     |                                        |                      |
|  - All Groups (foreach)                        | mt5-groups/group-name/{group_name}     | :white_check_mark:   |
|  - Hidden Routes (trading_account)             | mt5-groups/mt5-login/{trading_account} | :white_check_mark:   |
| Manager users                                  |                                        |                      |
|  - Create new user                             | users/create                           | :white_check_mark:   |
|  - View All users                              | users                                  | :white_check_mark:   |
|  - - Hidden Route (Login as Client)            | clients/{id}/login                     | :white_large_square: |
|  - - Hidden Route (Deposit)                    | clients/{id}/deposit                   | :white_large_square: |
|  - - Hidden Route (Withdraw)                   | clients/{id}/withdraw                  | :white_large_square: |
|  - - Hidden Route (Transfers)                  | clients/{id}/transfers                 | :white_large_square: |
|  - - Hidden Route (Ledger)                     | clients/{id}/ledger                    | :white_large_square: |
|  - - Hidden Route (View All Trading Accounts)  | clients/{id}/trading-accounts          | :white_large_square: |
|  - - Hidden Route (Add Trading Account)        | clients/{id}/add-trading-accounts      | :white_large_square: |
|  - - Hidden Route (Create New Trading Account) | clients/{id}/new-trading-accounts      | :white_large_square: |
|  - - Hidden Route (Edit Trading Account)       | clients/{id}/edit-trading-accounts     | :white_large_square: |
| Manage Roles                                   |                                        |                      |
|  - Create new Role                             | user-roles/create                      | :white_check_mark:   |
|  - View All Roles                              | user-roles                             | :white_check_mark:   |
| Departments                                    |                                        |                      |
|  - Create new Departments                      | departments/create                     | :white_check_mark:   |
|  - View All Departments                        | departments                            | :white_check_mark:   |
| Manage Status & Type                           |                                        |                      |
|  - Account Types                               | manage-status/account-types            | :white_check_mark:   |
|  - Account Status                              | manage-status/account-status           | :white_check_mark:   |
|  - Transaction Status                          | manage-status/transaction-status       | :white_check_mark:   |
|  - KYC Status                                  | manage-status/kyc-status               | :white_check_mark:   |
|  - Client Status                               | manage-status/client-status            | :white_check_mark:   |
|  - IB Status                                   | manage-status/ib-status                | :white_check_mark:   |
| App Settings                                   |                                        |                      |
|  - Basic Settings                              | app-settings/basic                     | :white_check_mark:   |
|  - Brand Settings                              | app-settings/brand-setting             | :white_check_mark:   |
|  - Automate Trnasactions                       | app-settings/automate-transaction      | :white_check_mark:   |
|  - Google reCaptcha                            | app-settings/google-recaptcha          | :white_check_mark:   |
|  - Bank Account                                | app-settings/bank-account              | :white_check_mark:   |
| Mail Settings                                  |                                        |                      |
|  - Email Setup                                 | mail-settings/email-setup              | :white_large_square: |
| MT5 Setings                                    |                                        |                      |
|  - Basic Setings                               | mt5-settings/basic                     | :white_check_mark:   |
|  - Downloads                                   | mt5-settings/downloads                 | :white_check_mark:   |
|  - Web Trader                                  | mt5-settings/web-trader                | :white_check_mark:   |
| Locations                                      |                                        |                      |
|  - Countries                                   | locations/countries                    | :white_check_mark: |
|  - States                                      | locations/states                       | :white_check_mark: |
|  - Cities                                      | locations/cities                       | :white_check_mark: |
| Logout                                         | logout                                 | :white_large_square: |

### Clients Menu and Route

| Menu                | Routes                     | Status               |
| ------------------- | -------------------------- | -------------------- |
| Profile             |                            |                      |
|  - My Profile       | profile                    | :white_large_square: |
|  - My Account       | my-account                 | :white_large_square: |
|  - Wallet           | wallet                     | :white_large_square: |
|  - Chagne Password  | change-password            | :white_large_square: |
| My Referral         | my-referrals               | :white_large_square: |
| Deposits / Withdraw |                            |                      |
|  - Wallet Ledger    | my-ledger/wallet-ledger    | :white_large_square: |
|  - Deposit          | my-ledger/deposit          | :white_large_square: |
|  - Withdraw         | my-ledger/withdraw         | :white_large_square: |
| Internal Transfers  |                            |                      |
|  - Transfer History | my-transfers/history       | :white_large_square: |
|  - Wallet to MT5    | my-transfers/wallet-to-mt5 | :white_large_square: |
|  - MT5 to Wallet    | my-transfers/mt5-to-wallet | :white_large_square: |
| Online Chat         | TawkTo Integration         | :white_large_square: |
| Web Trader          | web-trader                 | :white_large_square: |
| Downloads           | downloads                  | :white_large_square: |
| Logout              | logout                     | :white_large_square: |

### Extra Routes
| Controller      | Routes                | Status               |
| --------------- | --------------------- | -------------------- |
| Login           | login                 | :white_large_square: |
| Register        | register              | :white_large_square: |
| Forgot Password | reset/password        | :white_large_square: |
| Reset Password  | reset/{email}/{token} | :white_large_square: |
| Lock            | locked-out            | :white_large_square: |

 ### Features to be added
 - [ ] Help Desk
 - [ ] Email Editor