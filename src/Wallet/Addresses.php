<?php
/**
 * REQUEST URL PARAMETERS
 */
// walletId    bitcoin address (string)    Yes    The ID of the wallet
// address    bitcoin address (string)    Yes    The address on the wallet to get information of

/**
 * Response
 */
// address    The bitcoin address being looked up
// balance    Current balance (satoshis) in this address
// chain    The HD chain used to generate this address (0 for external receive addresses, 1 for change addresses, 10 for external SegWit receive addresses, 11 for SegWit change addresses)
// index    The index in the HD chain used to generate this address
// path    The HD path of the address on the wallet
// received    Total amount (satoshis) received on this address
// sent    Total amount (satoshis) sent on this address
// txCount    Total number of transactions on this address
// redeemScript    The redeemScript that may be used to spend funds from this P2SH address
