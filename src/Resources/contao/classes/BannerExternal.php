<?php
/**
 * Extension for Contao Open Source CMS, Copyright (C) 2005-2017 Leo Feyer
 *
 * BannerExternal - Frontend Helper Class
 *
 * @copyright  Glen Langer 2017 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @licence    LGPL
 * @filesource
 * @package    Banner
 * @see	       https://github.com/BugBuster1701/contao-banner-bundle
 */

namespace BugBuster\Banner;

use BugBuster\Banner\BannerImage;
use BugBuster\Banner\BannerTemplate;

/**
 * Class BannerExternal
 *
 * @copyright  Glen Langer 2017 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    Banner
 * @license    LGPL
 */
class BannerExternal
{

    /**
     * Banner extern
     * @var string
     */
    const BANNER_TYPE_EXTERN = 'banner_image_extern';
    
    protected $objBanners = null;
    protected $banner_cssID = null;
    protected $banner_class = null;
    
    public function __construct ($objBanners, $banner_cssID, $banner_class)
    {
        $this->objBanners   = $objBanners;
        $this->banner_cssID = $banner_cssID;
        $this->banner_class = $banner_class;
    }
    
    
    /**
     *
     * @return \stdClass
     */
    public function generateImageData()
    {
        //BannerImage Class
        $this->BannerImage = new BannerImage();
        //Banner Art und Größe bestimmen
        $arrImageSize = $this->BannerImage->getBannerImageSize($this->objBanners->banner_image_extern, self::BANNER_TYPE_EXTERN);
        //Falls Datei gelöscht wurde, Abbruch
        if (false === $arrImageSize)
        {
            $arrImageSize[2] = 0;
            BannerLog::log('Banner Image with ID "'.$this->objBanners->id.'" not found', __METHOD__ .':'. __LINE__, TL_ERROR);
            
            $objReturn = new \stdClass;
            $objReturn->FileSrc = null;
            $objReturn->Picture = null;
            $objReturn->ImageSize = $arrImageSize;
            
            return $objReturn;
        }
        //Banner Neue Größe 0:$Width 1:$Height
        $arrNewSizeValues = deserialize($this->objBanners->banner_imgSize);
        //Banner Neue Größe ermitteln, return array $Width,$Height,$oriSize
        $arrImageSizenNew = $this->BannerImage->getBannerImageSizeNew($arrImageSize[0],$arrImageSize[1],$arrNewSizeValues[0],$arrNewSizeValues[1]);
        //Umwandlung bei Parametern
        $FileSrc = html_entity_decode($this->objBanners->banner_image_extern, ENT_NOQUOTES, 'UTF-8');
        
        //fake the Picture::create
        $picture['img']   = array
        (
            'src'    => \StringUtil::specialchars(ampersand($FileSrc)),
            'width'  => $arrImageSizenNew[0],
            'height' => $arrImageSizenNew[1],
            'srcset' => \StringUtil::specialchars(ampersand($FileSrc))
        );
        $picture['alt']   = \StringUtil::specialchars(ampersand($this->objBanners->banner_name));
        $picture['title'] = \StringUtil::specialchars(ampersand($this->objBanners->banner_comment));
        
        $arrImageSize[0] = $arrImageSizenNew[0];
        $arrImageSize[1] = $arrImageSizenNew[1];
        $arrImageSize[3] = ' height="'.$arrImageSizenNew[1].'" width="'.$arrImageSizenNew[0].'"';
        
        $objReturn = new \stdClass;
        $objReturn->FileSrc = $FileSrc;
        $objReturn->Picture = $picture;
        $objReturn->ImageSize = $arrImageSize;
        
        return $objReturn;
    }
    
    /**
     * Generate Template Data
     *
     * @param array     $arrImageSize
     * @param string    $FileSrc
     * @param array     $picture
     * @return array    $arrBanners
     */
    public function generateTemplateData($arrImageSize, $FileSrc, $picture)
    {
        return BannerTemplate::generateTemplateData($arrImageSize, $FileSrc, $picture, $this->objBanners, $this->banner_cssID, $this->banner_class);
    }
    
}