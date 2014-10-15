<?php
  
  /*
   * Mandrill Hook for MODx FormIt
   * https://github.com/leviwheatcroft/formit-mandrill-hook
   *
   *
   * I've tried to make the options / defaults / param collection as
   * clear as I can. whatever keys you list in $keys will be populated
   * from the snippet call, and the form fields, with the form taking
   * precedence.
   *
   * The mandrill API accepts loads of options, you should check them
   * out here: https://mandrillapp.com/api/docs/messages.php.html
   *
   */
   
  require_once($modx->config['base_path'] . 'assets/php/mandrill/src/Mandrill.php');
  
  // list the values we want
  $keys = array(
    'email',
    'emailTpl',
    'emailSubject',
    'emailFrom',
    'emailFromName',
    'emailTo',
    'emailToName',
    'mandrillApiKey'
  );
  $keys = array_fill_keys($keys, false);

  // check if they've been passed in from snippet call
  $params = array_intersect_key(
    $scriptProperties,
    $keys
  );

  // over-write with values from the form
  $params = array_merge(
    $params,
    $hook->getValues()
  );

  // this is useful if you're trying to figure out what's going on..
  // check output in: core/cache/logs/error.log
  //$modx->log(MODX_LOG_LEVEL_ERROR, json_encode($params));

  $message = array(
    'text' => $modx->getChunk($params['emailTpl'], $params),
    'subject' => $params['emailSubject'],
    'from_email' => $params['emailFrom'],
    'from_name' => $params['emailFromName'],
    'to' => array(
      array(
        'email' => $params['emailTo'],
        'name' => $params['emailToName'],
        'type' => 'to'
      )
    )
  );

  $mandrill = new Mandrill($params['mandrillApiKey']);

try {
    $result = $mandrill->messages->send($message, false, 'Main Pool');
    $modx->log(MODX_LOG_LEVEL_INFO, 'Mandrill sent: ' . json_encode($result));
    return true;
    
} catch(Mandrill_Error $e) {
  $modx->log(MODX_LOG_LEVEL_ERROR, 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage());
    //$hook->addError('A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage());
    return false;
    
}

?>
