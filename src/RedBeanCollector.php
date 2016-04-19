<?php
namespace Filisko\DebugBar\DataCollector;

class RedBeanCollector extends \DebugBar\DataCollector\DataCollector implements \DebugBar\DataCollector\Renderable, \DebugBar\DataCollector\AssetProvider
{
    protected $debugStack;
    
    public function __construct($logger)
    {
        $this->debugStack = $logger;
    }
    
    public function collect()
    {
        // Get all SQL output
        $queries = [];
        
        if ($this->debugStack)
        {
            $output = $this->debugStack->grep(' ');
            $queries = array();
            foreach ($output as $key => $value)
            {
                // Clean all "resuldsets" outputs
                if (substr($value, 0, 9) == 'resultset')
                {
                    unset($output[$key]);
                }
                else
                {
                    $queries[] = array(
                        'sql' => $value,
                        //'duration_str' => 1,
                    );
                }
            }
        }

        
        return array(
            'nb_statements' => count($queries),
            'statements' => $queries,
            //'accumulated_duration_str' => 1,
        );
    }

    public function getName()
    {
        return 'redbean';
    }
    
    public function getWidgets()
    {
        return array(
            "RedBean" => array(
                "icon" => "inbox",
                "widget" => "PhpDebugBar.Widgets.SQLQueriesWidget",
                "map" => "redbean",
                "default" => "[]"
            ),
            "RedBean:badge" => array(
                "map" => "redbean.nb_statements",
                "default" => 0
            )
        );
    }

    public function getAssets()
    {
        return array(
            'css' => 'widgets/sqlqueries/widget.css',
            'js' => 'widgets/sqlqueries/widget.js'
        );
    }
}