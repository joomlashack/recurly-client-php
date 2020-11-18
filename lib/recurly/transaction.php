<?php
/**
 * Class Recurly_Transaction
 * @property string $uuid Transaction's unique identifier.
 * @property Recurly_Stub $account The URL of the account associated with the transaction.  Run get() to pull back a Recurly_Account
 * @property Recurly_Stub $invoice The URL of the invoice associated with the transaction.  Run get() to pull back a Recurly_Invoice
 * @property Recurly_Stub $subscriptions The URL of the subscriptions associated with the transaction.
 * @property Recurly_Transaction $original_transaction For refund transactions, the URL of the original transaction.  Run get() to pull back a Recurly_Transaction
 * @property string $action purchase, verify or refund.
 * @property integer $amount_in_cents Total transaction amount in cents.
 * @property integer $tax_in_cents Amount of tax or VAT within the transaction, in cents.
 * @property string $currency 3-letter currency for the transaction.
 * @property string $status success, declined, or void.
 * @property string $reference Transaction reference from your payment gateway.
 * @property string $source Source of the transaction. Possible values: transaction for one-time transactions, subscription for subscriptions, billing_info for updating billing info.
 * @property boolean $recurring True if transaction is recurring.
 * @property boolean $test True if test transaction.
 * @property boolean $voidable True if the transaction may be voidable, accuracy depends on your gateway.
 * @property string $refundable True if the transaction may be refunded.
 * @property string $ip_address Customer's IP address on the transaction, if applicable.
 * @property string $cvv_result CVV result, if applicable.
 * @property string $avs_result AVS result, if applicable.
 * @property string $avs_result_street AVS result for the street address, line 1.
 * @property string $avs_result_postal AVS result for the postal code.
 * @property DateTime $created_at Date the transaction took place.
 * @property DateTime $updated_at Date the transaction was last modified.
 * @property mixed[] $details Nested account and billing information submitted at the time of the transaction. When writing a client library, do not map these directly to Account or Billing Info objects.  Retrieve data by accessing the array details[0]->fieldname i.e. details[0]->email
 * @property string $payment_method The method of payment: (credit_card, paypal, eft, wire_transfer, money_order, check, or other).
 * @property DateTime $collected_at Date payment was collected
 * @property string $origin Describes how the transaction was triggered
 * @property string $gateway_type Identifies the payment gateway used to process the transaction
 * @property string $message The message from the gateway
 * @property string $description The description that gets sent to the gateway, if applicable.
 * @property null|Recurly_TransactionError $transaction_error
 */
class Recurly_Transaction extends Recurly_Resource
{
  /**
   * Get Transaction by uuid
   *
   * @param string $uuid
   * @param Recurly_Client $client Optional client for the request, useful for mocking the client
   * @return object Recurly_Transaction
   * @throws Recurly_Error
   */
  public static function get($uuid, $client = null) {
    return Recurly_Base::_get(Recurly_Transaction::uriForTransaction($uuid), $client);
  }

  /**
   * @throws Recurly_Error
   */
  public function create() {
    $this->_save(Recurly_Client::POST, Recurly_Client::PATH_TRANSACTIONS);
  }

  /**
   * Refund a previous, successful transaction
   *
   * @param int $amountInCents
   * @throws Recurly_Error
   */
  public function refund($amountInCents = null) {
    $uri = $this->uri();
    if (!is_null($amountInCents)) {
      $uri .= '?amount_in_cents=' . strval(intval($amountInCents));
    }
    $this->_save(Recurly_Client::DELETE, $uri);
  }

  /**
   * Attempt a void, otherwise refund
   *
   * @throws Recurly_Error
   */
  public function void() {
    trigger_error('Deprecated method: void(). Use refund() instead.', E_USER_NOTICE);
    $this->refund();
  }

  /**
   * @return null|string
   * @throws Recurly_Error
   */
  protected function uri() {
    if (!empty($this->_href))
      return $this->getHref();
    else if (!empty($this->uuid))
      return Recurly_Transaction::uriForTransaction($this->uuid);
    else
      throw new Recurly_Error('"uuid" is not supplied');
  }
  protected static function uriForTransaction($uuid) {
    return Recurly_Client::PATH_TRANSACTIONS . '/' . rawurlencode($uuid);
  }

  protected function getNodeName() {
    return 'transaction';
  }
  protected function getWriteableAttributes() {
    return array(
      'account', 'amount_in_cents', 'currency', 'description', 'accounting_code',
      'tax_exempt', 'tax_code', 'product_code', 'payment_method', 'collected_at'
    );
  }
}
