<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OrderManagement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ProductDisplay\Entity\Category;
use ProductDisplay\Entity\Product;
use UserManagement\Entity\Province;
use UserManagement\Entity\User;
use OrderManagement\Helper\TrunCate;
class HomeController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var
     */
    private $entityManager;
    private $homeManager;
    private $sessionContainer;

    public function __construct(
        $entityManager,
        $homeManager,
        $sessionContainer
    )
    {
        $this->entityManager = $entityManager;
        $this->homeManager = $homeManager;
        $this->sessionContainer = $sessionContainer;
    }

    public function indexAction()
    {
        $newProducts = $this->homeManager->getNewProduct(12);

        $view = new ViewModel([
            'newProducts' => $newProducts,
        ]);
        $this->layout('application/layout');

        return $view;
    }

    public function loaddistrictAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            if (!$data['province_id'] && !$data['province_name']) {
                $data = json_decode($this->getRequest()->getContent());
                $data = [
                    'province_name' => $data->province_name,
                ];
            }

            if ($data['province_id']) {
                $province_id = $data['province_id'];
                $province = $this->entityManager->getRepository(Province::class)
                    ->find($province_id);
            } else {
                $province_name = $data['province_name'];
                $province = $this->entityManager->getRepository(Province::class)
                    ->findOneBy(array('name' => $province_name));;
            }

            if ($province == null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $districts = $province->getDistricts();
            foreach ($districts as $d) {
                $districts_for_select[$d->getId()] = $d->getName();
            }

            $data_json = json_encode($districts_for_select);
            $this->response->setContent($data_json);
            return $this->response;
        }

        return 'only post method accepted';
    }

    public function loadprovinceAction()
    {
        $provinces = $this->entityManager->getRepository(Province::class)
            ->findAll();
        $arr = [];
        foreach ($provinces as $prov) {
            array_push($arr, $prov->getName());
        }
        $this->response->setContent(json_encode($arr));
        return $this->response;
    }
}
