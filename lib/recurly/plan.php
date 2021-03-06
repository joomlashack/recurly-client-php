<?php

/**
 * class Recurly_Plan
 * @property string $plan_code Unique code to identify the plan. This code may only contain the following characters: [a-z 0-9 @ - _ .]. Max of 50 characters.
 * @property string $name Plan name. Max of 255 characters.
 * @property Recurly_CurrencyList $unit_amount_in_cents Array of currency objects, see example below. Max 10000000.
 * @property string $description Optional plan description, not displayed.
 * @property string $plan_interval_unit days, or months, defaults to months.
 * @property integer $plan_interval_length Plan interval length, defaults to 1
 * @property string $trial_interval_unit days or months, defaults to months.
 * @property integer $trial_interval_length Defaults to 0, for no trial
 * @property string $success_url URL to redirect to after signup on the hosted payment pages.
 * @property string $accounting_code Accounting code for related invoice line items, code may only contain the following characters: [a-z 0-9 @ - _ .]. Max of 20 characters.
 * @property string $revenue_schedule_type Optional field for setting a revenue schedule type. This will determine how revenue for the associated Plan should be recognized. When creating a Plan, available schedule types are never, evenly, at_range_start, or at_range_end.
 * @property string $setup_fee_accounting_code Accounting code for a Setup Fee, code may only contain the following characters: [a-z 0-9 @ - _ .]. Max of 20 characters.
 * @property string $setup_fee_revenue_schedule_type Optional field for setting a revenue schedule type. This will determine how revenue for the associated Plan Setup Fee should be recognized. When creating a Plan Setup Fee, available schedule types are never, evenly, at_range_start, or at_range_end.
 * @property Recurly_CurrencyList $setup_fee_in_cents Array of currency objects, see examples. Max 10000000.
 * @property string $total_billing_cycles Number of billing cycles before the plan stops renewing, defaults to null for continuous auto renewal.
 * @property string $unit_name Deprecated Unit description for the quantity, e.g. users.
 * @property boolean $display_quantity Display the quantity field on the hosted payment page if true, defaults to false.
 * @property string $cancel_url Deprecated URL to redirect to on canceled signup on the hosted payment pages.
 * @property boolean $tax_exempt true exempts tax on the plan, false applies tax on the plan. If not defined, then defaults to the Plan and Site settings.
 * @property string $tax_code Optional field for EU VAT merchants and Avalara AvaTax Pro merchants. If you are using Recurly's EU VAT feature, you can use values of unknown, physical, or digital. If you have your own AvaTax account configured, you can use Avalara tax codes to assign custom tax rules.
 * @property string $add_on_code Add-on code. Max of 50 characters.
 * @property string $add_on_type Whether the add-on is Fixed-Price (fixed), or Usage-Based (usage).
 * @property integer $default_quantity Default quantity for the hosted pages.
 * @property boolean $display_quantity_on_hosted_page If true, display a quantity field on the hosted pages for the add-on.
 * @property boolean $optional Whether the add-on is optional for the customer to include in their purchase on the hosted payment page.
 * @property string $measured_unit_id The id of the measured unit on your site associated with the add-on.
 * @property string $usage_type If add_on_type = usage, you must set a usage_type, which can be price or percentage. If price, the price is defined in unit_amount_in_cents. If percentage, the percentage is defined in usage_percentage.
 * @property string $usage_percentage If add_on_type = usage and usage_type = percentage, you must set a usage_percentage. Must be between 0.0000 and 100.0000.
 * @property boolean $trial_requires_billing_info Setting to determine if subscriptions to this plan will always require billing info or will only require it when either not in a trial or when money is due, defaults to true.
 * @property boolean $auto_renew Determines whether subscriptions to this plan should auto-renew term at the end of the current term or expire. Defaults to true.
 * @property boolean $allow_any_item_on_subscriptions Used to determine whether items can be assigned as add-ons to individual subscriptions. If `true`, items can be assigned as add-ons to individual subscription add-ons. If `false`, only plan add-ons can be used.
 */
class Recurly_Plan extends Recurly_Resource
{
  function __construct($href = null, $client = null) {
    parent::__construct($href, $client);
    $this->setup_fee_in_cents = new Recurly_CurrencyList('setup_fee_in_cents');
    $this->unit_amount_in_cents = new Recurly_CurrencyList('unit_amount_in_cents');
  }

  /**
   * @param string $planCode The plan code
   * @param Recurly_Client $client Optional client for the request, useful for mocking the client
   * @return object Recurly_Resource or null
   * @throws Recurly_Error
   */
  public static function get($planCode, $client = null) {
    return Recurly_Base::_get(Recurly_Plan::uriForPlan($planCode), $client);
  }

  public function create() {
    $this->_save(Recurly_Client::POST, Recurly_Client::PATH_PLANS);
  }
  public function update() {
    $this->_save(Recurly_Client::PUT, $this->uri());
  }

  /**
   * @return object
   * @throws Recurly_Error
   */
  public function delete() {
    return Recurly_Base::_delete($this->uri(), $this->_client);
  }

  /**
   * @param string $planCode The plan code
   * @param Recurly_Client $client Optional client for the request, useful for mocking the client
   * @return object Recurly_Resource or null
   * @throws Recurly_Error
   */
  public static function deletePlan($planCode, $client = null) {
    return Recurly_Base::_delete(Recurly_Plan::uriForPlan($planCode), $client);
  }

  protected function uri() {
    if (!empty($this->_href))
      return $this->getHref();
    else
      return Recurly_Plan::uriForPlan($this->plan_code);
  }
  protected static function uriForPlan($planCode) {
    return self::_safeUri(Recurly_Client::PATH_PLANS, $planCode);
  }

  protected function getNodeName() {
    return 'plan';
  }
  protected function getWriteableAttributes() {
    return array(
      'plan_code', 'name', 'description', 'success_url', 'cancel_url',
      'display_donation_amounts', 'display_quantity', 'display_phone_number',
      'bypass_hosted_confirmation', 'unit_name', 'payment_page_tos_link',
      'plan_interval_length', 'plan_interval_unit', 'trial_interval_length',
      'trial_interval_unit', 'unit_amount_in_cents', 'setup_fee_in_cents',
      'total_billing_cycles', 'accounting_code', 'setup_fee_accounting_code',
      'revenue_schedule_type', 'setup_fee_revenue_schedule_type',
      'tax_exempt', 'tax_code', 'trial_requires_billing_info', 'auto_renew', 'allow_any_item_on_subscriptions'
    );
  }
}
