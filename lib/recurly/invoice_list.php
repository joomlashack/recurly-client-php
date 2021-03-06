<?php

class Recurly_InvoiceList extends Recurly_Pager
{
  public static function getPending($params = null, $client = null) {
    return Recurly_InvoiceList::get(Recurly_Pager::_setState($params, 'pending'), $client);
  }

  public static function getPaid($params = null, $client = null) {
    return Recurly_InvoiceList::get(Recurly_Pager::_setState($params, 'paid'), $client);
  }

  public static function getFailed($params = null, $client = null) {
    return Recurly_InvoiceList::get(Recurly_Pager::_setState($params, 'failed'), $client);
  }

  public static function getPastDue($params = null, $client = null) {
    return Recurly_InvoiceList::get(Recurly_Pager::_setState($params, 'past_due'), $client);
  }

  public static function get($params = null, $client = null) {
    $uri = self::_uriWithParams(Recurly_Client::PATH_INVOICES, $params);
    return new self($uri, $client);
  }

  public static function getForAccount($accountCode, $params = null, $client = null) {
    $uri = self::_uriWithParams(self::_safeUri(Recurly_Client::PATH_ACCOUNTS, $accountCode, Recurly_Client::PATH_INVOICES), $params);
    return new self($uri, $client);
  }

  protected function getNodeName() {
    return 'invoices';
  }
}
