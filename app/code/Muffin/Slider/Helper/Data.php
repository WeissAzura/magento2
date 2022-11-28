<?php
namespace Muffin\Slider\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\ScopeInterface;
use Muffin\Slider\Model\BannerFactory;
use Muffin\Slider\Model\SliderFactory;

class Data extends AbstractHelper
{
    const CONFIG_MODULE_PATH = 'muffinslider';
    /**
     * @var BannerFactory
     */
    public $bannerFactory;

    /**
     * @var SliderFactory
     */
    public $sliderFactory;

    /**
     * @var DateTime
     */
    protected DateTime $date;

    /**
     * @var HttpContext
     */
    protected HttpContext $httpContext;

    /**
     * Data constructor.
     *
     * @param DateTime $date
     * @param Context $context
     * @param HttpContext $httpContext
     * @param BannerFactory $bannerFactory
     * @param SliderFactory $sliderFactory
     */
    public function __construct(
        DateTime $date,
        Context $context,
        HttpContext $httpContext,
        BannerFactory $bannerFactory,
        SliderFactory $sliderFactory,
    ) {
        $this->date = $date;
        $this->httpContext = $httpContext;
        $this->bannerFactory = $bannerFactory;
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context);
    }
    public function getBannerCollection($id = null)
    {
        $collection = $this->bannerFactory->create()->getCollection();

        $collection->join(
            ['banner_slider' => $collection->getTable('muffin_bannerslider_banner_slider')],
            'main_table.banner_id=banner_slider.banner_id AND banner_slider.slider_id=' . $id,
            ['position']
        );

        $collection->addOrder('position', 'ASC');

        return $collection;
    }
    public function getActiveSliders()
    {
        return $this->sliderFactory->create()->getCollection()->addFieldToFilter('status', 1);
    }
    public function getBannerOptions($id)
    {
        $config = '';
        $sysConfig = $this->scopeConfig->getValue(self::CONFIG_MODULE_PATH, ScopeInterface::SCOPE_STORE);
        $slider = $this->sliderFactory->create()->load($id);
        if ($slider->getData('design') == 1) {
            if ($slider->getData('loop') == 1) {
                $config = 'loop: true,';
            }
            if ($slider->getData('autoplay') == 1 && $slider->getData('autoplaySpeed')) {
                if ($slider->getData('pauseOnHover') == 1) {
                    $config .= 'autoplay: {
                    delay: ' . $slider->getData('autoplaySpeed') . ',
                    pauseOnMouseEnter: true,
                    disableOnInteraction: false,
                },';
                } else {
                    $config .= 'autoplay: {
                    delay: ' . $slider->getData('autoplaySpeed') . ',
                },';
                }
            }
        } else {
            if ($sysConfig['muffinslider_design']['loop'] == 1) {
                $config = 'loop: true,';
            }
            if ($sysConfig['muffinslider_design']['autoplay'] == 1 && $sysConfig['muffinslider_design']['autoplaySpeed']) {
                if ($sysConfig['muffinslider_design']['pauseOnHover'] == 1) {
                    $config .= 'autoplay: {
                    delay: ' . $slider->getData('autoplaySpeed') . ',
                    pauseOnMouseEnter: true,
                    disableOnInteraction: false,
                },';
                } else {
                    $config .= 'autoplay: {
                    delay: ' . $slider->getData('autoplaySpeed') . ',
                },';
                }
            }
        }
        return $config;
    }
}
