<?php
/**
 * Query Params
 */
// address    string    Yes    Destination bitcoin address
// amount    number    Yes    Amount to be sent (in Satoshis), e.g. 0.1 * 1e8 for a tenth of a Bitcoin
// walletPassphrase    string    Yes    Passphrase for the wallet, used to decrypt the encrypted user key (on client)
// fee    number    No    The absolute fee in satoshis to be paid to the Bitcoin miners. HIGHLY recommended to leave undefined and use ‘feeTxConfirmTarget’ instead for dynamic fee estimates.
// message    string    No    User-provided string (this does not hit the blockchain)
// feeRate    number    No    The fee in satoshis /per kB/ of transaction size to be paid to the Bitcoin miners. HIGHLY recommended to leave undefined and use ‘feeTxConfirmTarget’ instead for dynamic fee estimates.
// feeTxConfirmTarget    number    No    Calculate fees per kilobyte, targeting transaction confirmation in this number of blocks. Default: 2, Minimum: 1, Maximum: 1000.
// maxFeeRate    number    No    An upper bound for the fee rate in satoshi per kB. Useful to set as a safety measure when using dynamic fees.
// minUnspentSize    number    No    Minimum amount in satoshis for an unspent to be considered usable. Defaults to 5460 (to combat tx dust spam).
// minConfirms    number    No    only choose unspent inputs with a certain number of confirmations. We recommend setting this to 1 and using enforceMinConfirmsForChange.
// enforceMinConfirms ForChange    boolean    No    Defaults to false. When constructing a transaction, minConfirms will only be enforced for unspents not originating from the wallet.
// sequenceId    string    No    A custom user-provided string that can be used to uniquely identify the state of this transaction before and after signing
// instant    boolean    No    set to true to request that the transaction be sent with BitGo’s instant guarantee against double-spends (fees may apply).
// forceChangeAtEnd    boolean    No    Forces the change address to be the last output.
// changeAddress    address (string)    No    Specifies the change address instead of creating a new one.
// noSplitChange    boolean    No    Set to true to disable automatic change splitting for purposes of unspent management.
// targetWalletUnspents    number    No    Specify a number of target unspents to maintain in the wallet.
// validate    boolean    No    Extra verification of the change addresses, which is always done server-side and is redundant client-side (defaults to true).
// feeSingleKeySourceAddress    address (string)    No    Use this single key address to pay fees
// feeSingleKeyWIF    private key in WIF    No    Use the address based on this private key to pay fees
// otp    string    No    A 7 digit code used to bypass a policy with the “getOTP” action type. See Wallet Policy for more details

// recipients    string    Yes    array of recipient objects and the amount to send to each e.g. [{address: ‘38BKDNZbPcLogvVbcx2ekJ9E6Vv94DqDqw’, amount: 1500}, ..]

/**
 * Success Response
 */
// tx    hex-encoded form of the signed transaction
// hash    the transaction id
// fee    amount in satoshis sent to the Bitcoin miners as part of this transaction
// feeRate    amount in satoshis per kilobyte sent to the Bitcoin miners as part of this transaction

/**
 * Error Response
 */
// error    the message from the policy that triggered this pending approval
// pendingApproval    the pending approval id, which will need to be approved by another user
// otp    set to true if the policy that fired was a “getOTP” type
// triggeredPolicy    id of the policy that triggered this pending approval
// status    the transaction status
