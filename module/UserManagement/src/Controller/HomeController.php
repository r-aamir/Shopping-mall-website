<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UserManagement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class HomeController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var
     */
    private $entityManager;
    private $sessionContainer;

    public function __construct(
        $entityManager,
        $sessionContainer
    )
    {
        $this->entityManager = $entityManager;
        $this->sessionContainer = $sessionContainer;
    }

    public function indexAction()
    {
        $view = new ViewModel([

        ]);
        $this->layout('application/layout');

        return $view;
    }
}
