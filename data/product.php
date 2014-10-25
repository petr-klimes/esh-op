<?php

/**
 * Product manager class
 */

namespace data;

class product {

    /**
     * databazova trida
     * @var \libs\system\database
     */
    private $db;

    /**
     * @var \data\product 
     */
    private static $instance;

    /**
     * Ziskani instance tridy
     * @return \data\product 
     */
    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    public function init() {
        $this->db = \libs\system\system::getObj('database');
    }

    public function getItemById($id) {
        $product = $this->db->con->query('SELECT * FROM product WHERE id=%i LIMIT 1', $id)->fetch();
        //$product['attribute'] = $this->getProductAttributes($id);
        $product['image'] = $this->getProductImages($id);
        $product['text'] = $this->getProductTexts($id);
        $product['discount'] = $this->getProductDiscounts($id);
        $product['variable'] = $this->getProductVariables($id);
        $product['attribute'] = $this->getProductAttributes($id);

        return $product;
    }

    public function getItemByEname($ename) {
        // zjistim id a zavolam getItemById
    }

    private function getProductAttributes($idProduct) {
        
    // prvne si zjistim jaky id attributu vytahovat a jaky jsou k nim id variablu
        
        $productAttributes = $this->db->con->query(''
                        . 'SELECT [atr].[id] AS [atrId], [atr].[name] AS [atrName], [atr].[title] AS [atrTitle], '
                        . '[atrGrp].[id] AS [atrgrpId], [atrGrp].[name] AS [atrgrpName], [atrGrp].[title] AS [atrgrpTitle], '
                        . '[var].[price] AS [atrPrice], [var].[weight] AS [atrWeight] '
                        . 'FROM [attribute] AS [atr] '
                        . 'JOIN [attribute_group] AS [atrGrp] ON [atr].[id_group] = [atrGrp].[id] '
                        . 'JOIN [product_variable] AS [proVar] ON [proVar].[id_product] = %i '
                        . 'JOIN [variable_attribute] AS [varAtr] ON [varAtr].[id_variable] = [proVar].[id_variable] '
                        . 'AND [varAtr].[id_attribute] = [atr].[id] '
                        . 'JOIN [variable] AS [var] ON [var].[id] = [varAtr].[id_variable] '
                        . 'ORDER BY [atr].[name]', $idProduct)->fetchAll();

        // zjisteni idecek attributu
        $attributeIds = array();
        foreach ($productAttributes as $value) {
            $attributeIds[] = $value['atrId'];
        }

        // nagroupuju attributy
        $ret = array();
        foreach ($productAttributes as $value) {
            $ret[$value['atrgrpId']]['id'] = $value['atrgrpId'];
            $ret[$value['atrgrpId']]['name'] = $value['atrgrpName'];
            $ret[$value['atrgrpId']]['title'] = $value['atrgrpTitle'];

            $item = array();
            $item['id'] = $value['atrId'];
            $item['name'] = $value['atrName'];
            $item['title'] = $value['atrTitle'];
            $item['price'] = $value['atrPrice'];
            $item['weight'] = $value['atrWeight'];
            $ret[$value['atrgrpId']]['item'][] = $item;
        }
        return $ret;
    }

    private function getProductImages($productId) {
        $images = $this->db->con->query(''
                        . 'SELECT [img].[id] AS [id], [img].[name] AS [name], [img].[title] AS [title], [img].[src] AS [src], [img].[order] AS [order], '
                        . '[proImg].[id_variable] AS [id-variable] '
                        . 'FROM [image] AS [img] '
                        . 'JOIN [product_image] AS [proImg] ON [proImg].[id_image] = [img].[id] '
                        . 'WHERE [proImg].[id_product] = %i '
                        . 'AND [img].[active] = 1 '
                        . 'ORDER BY [img].[order]', $productId)->fetchAll();
        return $images;
    }

    private function getProductTexts($productId) {
        $texts = $this->db->con->query(''
                        . 'SELECT [txt].[id] AS [id], [txt].[title] AS [title], [txt].[text] AS [text], [txt].[order] AS [order], '
                        . '[lang].[id] AS [lang-id], [lang].[name] AS [lang-name], [lang].[code] AS [lang-code] '
                        . 'FROM [text] AS [txt] '
                        . 'JOIN [product_text] AS [proTxt] ON [proTxt].[id_text] = [txt].[id] '
                        . 'JOIN [language] AS [lang] ON [proTxt].[id_language] = [lang].[id] '
                        . 'WHERE [proTxt].[id_product] = %i '
                        . 'AND [txt].[active] = 1 '
                        . 'ORDER BY [txt].[order]', $productId)->fetchAll();
        return $texts;
    }

    private function getProductDiscounts($productId) {
        $discount = $this->db->con->query(''
                        . 'SELECT [disc].[id] AS [id], [disc].[name] AS [name], [disc].[title] AS [title], [disc].[old_price] AS [old-price], '
                        . '[disc].[valid_from] AS [valid-from], [disc].[valid_to] AS [valid-to], '
                        . '[ico].[id] AS [icon-id], [ico].[name] AS [ico-name], [ico].[title] AS [ico-title], '
                        . '[proDisc].[id_variable] AS [id-variable]'
                        . 'FROM [discount] AS [disc] '
                        . 'JOIN [product_discount] AS [proDisc] ON [proDisc].[id_discount] = [disc].[id] '
                        . 'JOIN [icon] AS [ico] ON [ico].[id] = [disc].[id_icon] '
                        . 'WHERE [proDisc].[id_product] = %i '
                        . 'AND [disc].[valid_from] < CURDATE() AND [disc].[valid_to] > CURDATE()'
                        . 'AND [disc].[active] = 1 ', $productId)->fetchAll();
        return $discount;
    }

    private function getProductVariables($productId) {
        $vars = $this->db->con->query(''
                        . 'SELECT [var].[id] AS [id], [var].[name] AS [name],[var].[price] AS [price], [var].[weight] AS [weight] '
                        . 'FROM [variable] AS [var] '
                        . 'JOIN [product_variable] AS [proVar] ON [proVar].[id_variable] = [var].[id] '
                        . 'WHERE [proVar].[id_product] = %i ', $productId)->fetchAll();
        return $vars;
    }

}
