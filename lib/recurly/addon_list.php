<?php

class Recurly_AddonList extends Recurly_Pager
{
  public static function get($planCode, $params = null, $client = null)
  {
    $uri = self::_uriWithParams(self::_safeUri(Recurly_Client::PATH_PLANS, $planCode, Recurly_Client::PATH_ADDONS), $params);
    return new self($uri, $client);
  }

  protected function getNodeName() {
    return 'add_ons';
  }
}
