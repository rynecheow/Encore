<?php
/**
 * Created by PhpStorm.
 * User: LiHao
 * Date: 11/3/13
 * Time: 11:04 PM
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SeatSelectionController
{
    /**
     * @Route("/seats/{id}", requirements={"id" = "\d+"})
     */
    public function seatSelectionAction($id)
    {

    }
} 