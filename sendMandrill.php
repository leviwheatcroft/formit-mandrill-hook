<?php
  
  require_once($modx->config['base_path'] . 'assets/php/mandrill/src/Mandrill.php');

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

  $hookValues = $hook->getValues();

  foreach ($keys as $key) {
    $values[$key] = $hookValues[$key] ? $hookValues[$key] : $scriptProperties[$key];
  }

  $message = array(
    'text' => $modx->getChunk($values['emailTpl'], $values),
    'subject' => $values['emailSubject'],
    'from_email' => $values['emailFrom'] ? $values['emailFrom'] : $values['email'],
    'from_name' => $values['emailFromName'] ? $values['emailFromName'] : 'website contact',
    'to' => array(
      array(
        'email' => $values['emailTo'],
        'name' => $values['emailToName'],
        'type' => 'to'
      )
    )
  );

  $mandrill = new Mandrill($values['mandrillApiKey']);

try {
    $result = $mandrill->messages->send($message, false, 'Main Pool');
    $modx->log(MODX_LOG_LEVEL_INFO, 'Mandrill sent: ' . json_encode($result));
    return true;
    
} catch(Mandrill_Error $e) {
    $hook->addError('A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage());
    return false;
    
}

?>
