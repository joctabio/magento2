<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Ui\Component;

/**
 * Class Paging
 */
class Paging extends AbstractComponent
{
    const NAME = 'paging';

    /**
     * Get component name
     *
     * @return string
     */
    public function getComponentName()
    {
        return static::NAME;
    }

    /**
     * Prepare component data
     *
     * @return void
     */
    public function prepare()
    {
        parent::prepare();

        $this->prepareConfiguration();
        $this->prepareOptions();

        $paging = $this->getContext()->getRequestParam('paging');

        $this->getContext()->getDataProvider()->setLimit($this->getOffset($paging),  $this->getSize($paging));

        $jsConfig = $this->getConfiguration($this);
        $this->getContext()->addComponentDefinition($this->getComponentName(), $jsConfig);
    }

    /**
     * Get offset
     *
     * @param array|null $paging
     * @return int
     */
    protected function getOffset($paging)
    {
        $defaultPage = $this->getData('config/current') ?: 1;
        return (int) (isset($paging['current']) ? $paging['current'] : $defaultPage);
    }

    /**
     * Get size
     *
     * @param array|null $paging
     * @return int
     */
    protected function getSize($paging)
    {
        $defaultLimit = $this->getData('config/pageSize') ?: 20;
        return (int) (isset($paging['pageSize']) ? $paging['pageSize'] : $defaultLimit);
    }

    /**
     * Prepare paging options
     *
     * @return void
     */
    protected function prepareOptions()
    {
        $config = $this->getData('config');
        if (isset($config['options'])) {
            $config['options'] = array_values($config['options']);
            foreach ($config['options'] as &$item) {
                $item['value'] = (int) $item['value'];
            }
            unset($item);
            $this->setData('config', $config);
        }
    }

    /**
     * Get default parameters
     *
     * @return array
     */
    protected function getDefaultConfiguration()
    {
        return  [
            'options' => [
                '20' => [
                    'value' => 20,
                    'label' => 20
                ],
                '30' => [
                    'value' => 30,
                    'label' => 30
                ],
                '50' => [
                    'value' => 50,
                    'label' => 50
                ],
                '100' => [
                    'value' => 100,
                    'label' => 100
                ],
                '200' => [
                    'value' => 200,
                    'label' => 200
                ],
            ],
            'pageSize' => 20,
            'current' => 1
        ];
    }
}
