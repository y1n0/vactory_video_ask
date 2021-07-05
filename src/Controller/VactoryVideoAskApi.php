<?php
/**
 * @file
 * Contains \Drupal\vactory_video_ask\Controller\VactoryVideoAskApi.
 */

namespace Drupal\vactory_video_ask\Controller;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller VactoryVideoAskApi.
 */
class VactoryVideoAskApi extends ControllerBase {


  public function postResult( Request $request ) {
    
    $account = \Drupal::currentUser();
    $user = \Drupal\user\Entity\User::load($account->id());
    dpm($account->id());

    if (isset($user->field_video_ask) && !empty($user->field_video_ask->value) ) {
        return new JsonResponse([
            'message' => 'Data already saved'
            ,
            'id' => $account->id()
        ], 500);
    }else{
    $data = json_decode( $request->getContent(), TRUE );
    if(empty($data)){
        return new JsonResponse([
            'message' => 'Invalid data',
            'id' => $account->id()

          ], 500);
    }else{
        
        $user->set('field_video_ask', $request->getContent());
        $user->save();
        return new JsonResponse([
            'message' => 'Data saved successfully',
            'id' => $account->id()
        ]);
    }

    }
    
  }




}