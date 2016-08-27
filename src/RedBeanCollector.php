<?php
namespace Filisko\DebugBar\DataCollector;

class RedBeanCollector extends \DebugBar\DataCollector\DataCollector implements \DebugBar\DataCollector\Renderable, \DebugBar\DataCollector\AssetProvider
{
    /**
     * Whether to show or not '--keep-cache' in your queries.
     * @var boolean
     */
    public static $showKeepCache = false;

    /**
     * Logger must implement RedBean's Logger interface.
     * @var \RedBeanPHP\Logger
     */
    protected $logger;

    /**
     * Set RedBean's logger
     * @param \RedBeanPHP\Logger $logger
     */
    public function __construct(\RedBeanPHP\Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Collect all the executed queries by now.
     */
    public function collect()
    {
        // Get all SQL output
        $queries = [];

        $output = $this->logger->grep(' ');
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
                if (! self::$showKeepCache) {
                    $value = str_replace('-- keep-cache', '', $value);
                }
                $queries[] = array(
                    // 1 space maximum and no HTML included tags by RedBean
                    'sql' => strip_tags(preg_replace('!\s+!', ' ', $value))
                    //'duration_str' => 1,
                );
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
            "Database" => array(
                "icon" => "inbox",
                "widget" => "PhpDebugBar.Widgets.SQLQueriesWidget",
                "map" => "redbean",
                "default" => "[]"
            ),
            "Database:badge" => array(
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
