<?php


namespace backend\components;

use yii\grid\ActionColumn;
use Yii;
use yii\helpers\Html;

class ActionColumnExtends extends ActionColumn
{

    public $icons = [
        'pencil' => '<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.7071 13.7071C4.59733 13.8169 4.4635 13.8996 4.31622 13.9487L1.31622 14.9487C0.95689 15.0685 0.560722 14.9749 0.29289 14.7071C0.0250576 14.4393 -0.0684649 14.0431 0.0513133 13.6838L1.05131 10.6838C1.10041 10.5365 1.18312 10.4027 1.29289 10.2929L9.08578 2.5C9.86683 1.71895 11.1332 1.71895 11.9142 2.5L12.5 3.08579C13.281 3.86684 13.281 5.13317 12.5 5.91422L4.7071 13.7071ZM2 11L9.79289 3.20711C10.1834 2.81658 10.8166 2.81658 11.2071 3.20711L11.7929 3.7929C12.1834 4.18342 12.1834 4.81658 11.7929 5.20711L4 13L0.999997 14L2 11Z" fill="black"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.85355 2.56066C8.65829 2.3654 8.34171 2.3654 8.14644 2.56066L4.85355 5.85356C4.65829 6.04882 4.34171 6.04882 4.14644 5.85356C3.95118 5.65829 3.95118 5.34171 4.14644 5.14645L7.43934 1.85356C8.02512 1.26777 8.97487 1.26777 9.56066 1.85356L9.85355 2.14645C10.0488 2.34171 10.0488 2.65829 9.85355 2.85356C9.65829 3.04882 9.34171 3.04882 9.14644 2.85356L8.85355 2.56066Z" fill="black"/>
            <path d="M12.2929 1.20711C12.6834 0.816584 13.3166 0.816584 13.7071 1.20711L13.7368 1.23679C14.1155 1.61553 14.1286 2.22543 13.7664 2.62005L12.5 4L11 2.5L12.2929 1.20711Z" fill="black"/>
            </svg>',
        'eye' => '<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 6C16 6 13 0.5 8 0.5C3 0.5 0 6 0 6C0 6 3 11.5 8 11.5C13 11.5 16 6 16 6ZM1.1727 6C1.22963 6.08679 1.29454 6.18323 1.36727 6.28758C1.70216 6.76807 2.19631 7.4071 2.83211 8.04289C4.12103 9.33182 5.88062 10.5 8 10.5C10.1194 10.5 11.879 9.33182 13.1679 8.04289C13.8037 7.4071 14.2978 6.76807 14.6327 6.28758C14.7055 6.18323 14.7704 6.08679 14.8273 6C14.7704 5.91321 14.7055 5.81677 14.6327 5.71242C14.2978 5.23193 13.8037 4.5929 13.1679 3.95711C11.879 2.66818 10.1194 1.5 8 1.5C5.88062 1.5 4.12103 2.66818 2.83211 3.95711C2.19631 4.5929 1.70216 5.23193 1.36727 5.71242C1.29454 5.81677 1.22963 5.91321 1.1727 6Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 3.5C6.61929 3.5 5.5 4.61929 5.5 6C5.5 7.38071 6.61929 8.5 8 8.5C9.38071 8.5 10.5 7.38071 10.5 6C10.5 4.61929 9.38071 3.5 8 3.5ZM4.5 6C4.5 4.067 6.067 2.5 8 2.5C9.933 2.5 11.5 4.067 11.5 6C11.5 7.933 9.933 9.5 8 9.5C6.067 9.5 4.5 7.933 4.5 6Z" fill="black"/>
                    </svg>
                     ',
        'trash' => '<svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.5 5.5C4.77614 5.5 5 5.72386 5 6V12C5 12.2761 4.77614 12.5 4.5 12.5C4.22386 12.5 4 12.2761 4 12V6C4 5.72386 4.22386 5.5 4.5 5.5Z" fill="black"/>
                    <path d="M7 5.5C7.27614 5.5 7.5 5.72386 7.5 6V12C7.5 12.2761 7.27614 12.5 7 12.5C6.72386 12.5 6.5 12.2761 6.5 12V6C6.5 5.72386 6.72386 5.5 7 5.5Z" fill="black"/>
                    <path d="M10 6C10 5.72386 9.77614 5.5 9.5 5.5C9.22386 5.5 9 5.72386 9 6V12C9 12.2761 9.22386 12.5 9.5 12.5C9.77614 12.5 10 12.2761 10 12V6Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 3C13.5 3.55228 13.0523 4 12.5 4H12V13C12 14.1046 11.1046 15 10 15H4C2.89543 15 2 14.1046 2 13V4H1.5C0.947715 4 0.5 3.55228 0.5 3V2C0.5 1.44772 0.947715 1 1.5 1H5C5 0.447715 5.44772 0 6 0H8C8.55229 0 9 0.447715 9 1H12.5C13.0523 1 13.5 1.44772 13.5 2V3ZM3.11803 4L3 4.05902V13C3 13.5523 3.44772 14 4 14H10C10.5523 14 11 13.5523 11 13V4.05902L10.882 4H3.11803ZM1.5 3V2H12.5V3H1.5Z" fill="black"/>
                    </svg> '

    ];

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = $this->icons[$iconName];
                return Html::a($icon, $url, $options);
            };
        }
    }
}