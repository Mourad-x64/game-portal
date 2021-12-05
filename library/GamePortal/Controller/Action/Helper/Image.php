<?php

/**
 * class GamePortal_Controller_Action_Helper_Image 
 * 
 * Image action helper (for GamePortal).
 * permet de manipuler facilement les images via un controller Image.
 * Utilise la librairie PHPImageWorkshop de Clément Guillemain {@link https://github.com/Sybio?tab=repositories git repo}.
 * 
 * TODO : 
 *  Utiliser ImageMagick si installé ou GD par défaut.
 *  Intégrer la librairie phpThumb à la place de PHPImageWorkshop pour plus de fonctionnalités.
 *  Intégrer la gestion de la mise en cache des images.
 */
class GamePortal_Controller_Action_Helper_Image extends Zend_Controller_Action_Helper_Abstract {
    ///////////////////
    //    params     //
    ///////////////////

    /**
     *  
     */
    protected $_image;

    /**
     * 
     */
    protected $_filename;

    /**
     *  
     */
    protected $_width;

    /**
     * 
     */
    protected $_height;

    /**
     * 
     */
    protected $_bgColor;

    /**
     *      
     */
    protected $_mimeType;

    ///////////////////
    //    methods    //
    ///////////////////

    /**
     * 
     */
    public function __construct() {
        $this->_image = '';
        $this->_filename = '';
        $this->_width = 50;
        $this->_height = 50;
        $this->_bgColor = NULL;
        $this->_mimeType = '';
    }

    /**
     * créé une image (layer ImageWorkshop) à partir de $file
     * ou une image vierge.
     * 
     * @param string $file chemin 'absolu' de l'image.
     *  
     * @return GamePortal_Controller_Action_Helper_Image
     */
    public function image($file = NULL) {

        if (!empty($file)) {
            // get filename            
            $this->_filename = basename($file);

            // get the mime type (!!!! needs php_fileinfo extansion !!!!)
            $file_info = new finfo(FILEINFO_MIME_TYPE);
            $this->_mimeType = $file_info->buffer(file_get_contents($file));

            // set the default bg color
            if ($this->_mimeType == 'image/png') {
                $this->_bgColor = 'transparent';
            } else {
                $this->_bgColor = '000000';
            }

            // create the new image layer from file
            $this->_image = PHPImageWorkshop_ImageWorkshop::initFromPath($file);

            // getting image info
            $this->_width = $this->_image->getWidth();
            $this->_height = $this->_image->getHeight();
        } else {
            // create a virgin image layer
            $this->_image = PHPImageWorkshop_ImageWorkshop::initVirginLayer($this->_width, $this->_height, $this->_bgColor);
        }

        return $this;
    }

    /**
     * Réduit une image pour la faire tenir dans un espace défini.
     * L'image est conservée (pas de crop) mais des bandes noires
     * ou blanches peuvent combler les vides (suivant $_bgColor).
     * Par défaut l'image est centrée via $align.
     * 
     * @param integer $width largeure souhaitée.
     * @param integer $height hauteure souhaitée.
     * 
     * @return GamePortal_Controller_Action_Helper_Image Updated instance.
     */
    public function compact($width, $height, $align = 'MM') {

        $this->_image->resizeInPixel($width, $height, true, 0, 0, $align);

        return $this;
    }

    /**
     * Génère une miniature qui s'adapte au mieux au dimensions passées en paramètres.
     * Le ratio de l'image originale est préservé (pas déformée ni agrandie).
     * 
     * @param integer $width La largeure souhaitée.
     * @param integer $height La hauteure souhaitée.
     * 
     * @return GamePortal_Controller_Action_Helper_Image Updated instance.
     */
    public function thumbnail($width, $height) {

        $placeHolderRatio = $width / $height;
        $imageRatio = $this->_width / $this->_height;

        // test si l'image est plus grande que l'encart:
        if ($this->_width > $width && $this->_height > $height) {

            // test du ratio de l'encart
            switch ($placeHolderRatio) {
                // carré
                case ($placeHolderRatio == 1):

                    if ($imageRatio == 1) {
                        // si l'image est carré on la réduit juste au dimension de l'encart carré.
                        $this->_image->resizeInPixel($width, $height, TRUE);
                    } elseif ($imageRatio > 1) {
                        // si l'image est en paysage, on recadre l'image en un carré le plus grand possible (crop centré).                    
                        $this->_image->cropMaximumInPixel(0, 0, "MM");
                        // et on la réduit au dimensions de l'encart carré.
                        $this->_image->resizeInPixel($width, $height, TRUE);
                    } elseif ($imageRatio < 1) {
                        // si l'image est au format portrait on réduit le plus petit coté et crop le reste par le haut. 
                        $this->_image->resizeByNarrowSideInPixel($width, TRUE);
                        $this->_image->cropInPixel($width, $height, 0, 0, 'LT');
                    }
                    
                    break;
                // paysage
                case ($placeHolderRatio > 1):

                    if ($imageRatio == 1) {
                        // si l'image est carré on la réduit à la largeur de l'encart paysage puis on crop ce qui dépasse (crop centré).
                        $this->_image->resizeInPixel($width, $width, TRUE);
                        $this->_image->cropInPixel($width, $height, 0, 0, 'MM');
                    } elseif ($imageRatio > 1) {
                        // si l'image est en paysage, on réduit l'image paysage à la hauteur de l'encart paysage.                   
                        $this->_image->resizeByNarrowSideInPixel($height, TRUE);
                        // et on recentre l'image en coupant ce qui dépasse des cotés (crop centré).                    
                        $this->_image->cropInPixel($width, $height, 0, 0, 'MM');
                    } elseif ($imageRatio < 1) {
                        // si l'image est au format portrait on réduit le plus petit coté et crop le reste par le haut. 
                        $this->_image->resizeByNarrowSideInPixel($width, TRUE);
                        $this->_image->cropInPixel($width, $height, 0, 0, 'LT');
                    }

                    break;
                // portrait
                case ($placeHolderRatio < 1):

                    if ($imageRatio == 1) {
                        // si l'image est carré on la réduit à la hauteur de l'encart portrait puis on recadre en coupant ce qui dépasse (crop centré).
                        $this->_image->resizeInPixel($height, $height, TRUE);
                        $this->_image->cropInPixel($width, $height, 0, 0, 'MM');
                    } elseif ($imageRatio > 1) {
                        // si l'image est en paysage, on la réduit à la hauteur de l'encart portrait.                   
                        $this->_image->resizeByNarrowSideInPixel($height, TRUE);
                        // et on recentre l'image en coupant ce qui dépasse des cotés (crop centré).                    
                        $this->_image->cropInPixel($width, $height, 0, 0, 'MM');
                    } elseif ($imageRatio < 1) {
                        // si l'image est au format portrait on réduit le plus petit coté et crop le reste par le haut. 
                        $this->_image->resizeByNarrowSideInPixel($width, TRUE);
                        $this->_image->cropInPixel($width, $height, 0, 0, 'LT');
                    }

                    break;
            }
        }  else {
            // si l'image est plus petite que l'encart on la superpose sur un fond noir de la taille de l'encart.
            $void = PHPImageWorkshop_ImageWorkshop::initVirginLayer($width, $height, '000000');
            $void->addLayerOnTop($this->_image, 0, 0, 'MM');
            $void->mergeAll();
            // update main image layer and bg color
            $this->_image = $void;
            $this->_bgColor = '000000';
        }

        // update width and height 
        $this->_width = $this->_image->getWidth();
        $this->_height = $this->_image->getHeight();         

        return $this;
    }

    /**
     *
     * @return void
     */
    public function render() {

        header('Content-type: ' . $this->_mimeType);
        header('Content-Disposition: filename="' . $this->_filename . '"');

        switch ($this->_mimeType) {
            case 'image/jpeg':
                imagejpeg($this->_image->getResult($this->_bgColor), null, 95); // We choose to show a JPEG (quality of 95%)  
                break;
            case 'image/gif':
                imagegif($this->_image->getResult($this->_bgColor));
                break;
            case 'image/png':
                imagepng($this->_image->getResult($this->_bgColor), null, 8); // png quality 8/9            
                break;
        }
    }

    /**
     * 
     */
    public function save() {
        return $this;
    }

    /**
     * Strategy pattern: proxy to image()     
     * 
     * note : moins rapide 
     * 
     * @return void
     */
    public function direct($file = NULL) {
        return $this->image($file);
    }

    ////////////////
    //   getters  //
    ////////////////

    public function getMimeType() {
        return $this->_mimeType;
    }

    public function getFilename() {
        return $this->_filename;
    }

    public function getWidth() {
        return $this->_width;
    }

    public function getHeight() {
        return $this->_height;
    }

    public function getBgColor() {
        return $this->_bgColor;
    }

}
