<?php

namespace ProductDisplay\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ProductDisplay\Entity\Comment;
use ProductDisplay\Entity\Keyword;
use ProductDisplay\Entity\ProductColorImage;
use ProductDisplay\Entity\Review;
use ProductDisplay\Entity\ProductMaster;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="\ProductDisplay\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DELETED = 0;
    const MAX_VIEWS = 2000000000;
    /**
     * @ORM\OneToMany(targetEntity="\ProductDisplay\Entity\Comment", mappedBy="product")
     * @ORM\JoinColumn(name="id", referencedColumnName="product_id")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="\ProductDisplay\Entity\Review", mappedBy="product")
     * @ORM\JoinColumn(name="id", referencedColumnName="product_id")
     */
    protected $reviews;

    /**
     * @ORM\ManyToMany(targetEntity="\ProductDisplay\Entity\Keyword", inversedBy="products")
     * @ORM\JoinTable(name="product_keywords",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="keyword_id", referencedColumnName="id")}
     *      )
     */
    protected $keywords;

    /**
     * @ORM\OneToMany(targetEntity="\ProductDisplay\Entity\ProductColorImage", mappedBy="product")
     * @ORM\JoinColumn(name="id", referencedColumnName="product_id")
     */
    protected $product_color_images;

    /**
     * @ORM\OneToMany(targetEntity="\ProductDisplay\Entity\ProductMaster", mappedBy="product")
     * @ORM\JoinColumn(name="id", referencedColumnName="product_id")
     */
    protected $product_masters;

    /**
     * Constructor.
     */

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->keywords = new ArrayCollection();
        $this->product_color_images = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->product_masters = new ArrayCollection();
    }

    /**
     * Returns comments for this product.
     * @return array
     */

    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Adds a new comment to this product.
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Returns comments for this product.
     * @return array
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Adds a new comment to this product.
     * @param $comment
     */
    public function addReview($review)
    {
        $this->reviews[] = $review;
        $this->rate_sum = $this->rate_sum + $review->getRate();
        $this->rate_count++;
    }


    /**
     * Returns product_images for this product.
     * @return array
     */
    public function getProductColorImages()
    {
        return $this->product_color_images;
    }

    /**
     * Adds a new product_image to this product.
     * @param $product_color_image
     */
    public function addProductColorImage($product_color_image)
    {
        $this->product_color_images[] = $product_color_image;
    }

    /**
     * Returns product_images for this product.
     * @return array
     */
    public function getProductMasters()
    {
        return $this->product_masters;
    }

    /**
     * Adds a new product_image to this product.
     * @param $product_master
     */
    public function addProductMaster($product_master)
    {
        $this->product_masters[] = $product_master;
    }

    // Returns keywords for this product.
    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getInfoKeywords()
    {
        foreach ($this->getKeywords() as $key) {
            $data[] = $key->getKeyword();
        }
        return $data;
    }

    // Adds a new keyword to this product.
    public function addKeyword($keyword)
    {
        $this->keywords[] = $keyword;
    }

    // Removes association between this product and the given keyword.
    public function removeKeywordAssociation($keyword)
    {
        $this->keywords->removeElement($keyword);
    }

    /**
     * @ORM\ManyToOne(targetEntity="\ProductDisplay\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /*
     * Returns associated category.
     * @return \ProductDisplay\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function getAllCategory()
    {
        $cur_c = $this->getCategory();
        $c_arr = [];
        while ($cur_c->getParent() != null) {
            array_push($c_arr, $cur_c->getName());
            $cur_c = $cur_c->getParent();
        }
        array_push($c_arr, $cur_c->getName());
        return $c_arr;
    }

    /**
     * Sets associated category.
     * @param \ProductDisplay\Entity\Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        $category->addProduct($this);
    }


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="alias")
     */
    protected $alias;

    /**
     * @ORM\Column(name="price")
     */
    protected $price;

    /**
     * @ORM\Column(name="current_price")
     */
    protected $current_price;

    /**
     * @ORM\Column(name="intro")
     */
    protected $intro;

    /**
     * @ORM\Column(name="image")
     */
    protected $image;

    /**
     * @ORM\Column(name="description")
     */
    protected $description;

    /**
     * @ORM\Column(name="status")
     */
    protected $status = 0;

    /**
     * @ORM\Column(name="views")
     */
    protected $views = 0;

    /**
     * @ORM\Column(name="popular_level")
     */
    protected $popular_level = 0;
    /**
     * @ORM\Column(name="rate_sum")
     */
    protected $rate_sum = 0;

    /**
     * @ORM\Column(name="rate_count")
     */
    protected $rate_count = 0;

    /**
     * @ORM\Column(name="date_created")
     */
    protected $date_created;

    // Returns ID of this product.
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getIntro()
    {
        return $this->intro;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function getRateSum()
    {
        return $this->rate_sum;
    }

    public function setRateSum($rate_sum)
    {
        $this->rate_sum = $rate_sum;
    }

    public function getPopularLevel()
    {
        return $this->popular_level;
    }

    public function setPopularLevel($popular_level)
    {
        $this->popular_level = $popular_level;
    }

    public function getRateCount()
    {
        return $this->rate_count;
    }

    public function setRateCount($rate_count)
    {
        $this->rate_count = $rate_count;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function getCurrentPrice()
    {
        return $this->getPrice();
    }

    public function getSizeAndImageEachColors()
    {
        $product_masters = $this->getProductMasters();
        $product_color_images = $this->getProductColorImages();
        $size_and_images = [];
        // get Size each Color
        foreach ($product_masters as $pm) {
            if (empty($size_and_images[$pm->getColorId()]))
                $size_and_images[$pm->getColorId()] = ['size' => [], 'image' => ['0' => null, '1' => []]];
            array_push($size_and_images[$pm->getColorId()]['size'], $pm->getSizeId());

        };

        // get Image each Color
        foreach ($product_color_images as $pci) {
            foreach ($pci->getImages() as $image) {
                if ($image->getType() == IMAGE::MAIN) {
                    $size_and_images[$pci->getColorId()]['image'][0] = $image->getImage();
                } else {
                    array_push($size_and_images[$pci->getColorId()]['image'][1], $image->getImage());
                }
            }
        }

        return $size_and_images;
    }

    public function getColors()
    {
        $colors = [];
        $product_color_images = $this->getProductColorImages();
        foreach ($product_color_images as $pci) {
            array_push($colors, $pci->getColorId());
        }

        return $colors;
    }

    public function getColorsInWord()
    {
        $colors = [];
        $product_color_images = $this->getProductColorImages();
        foreach ($product_color_images as $pci) {
            array_push($colors, $pci->getColorInWord());
        }

        return $colors;
    }

    public function getMainComments()
    {
        $mainComments = [];
        foreach ($this->comments as $c) {
            if ($c->getParentId() == null) {
                array_push($mainComments, $c);
            }
        }

        return $mainComments;
    }
}
