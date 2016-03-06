<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Controller;

use kaluzki\JetBrains\LiveTemplate\Model;
use kaluzki\JetBrains\LiveTemplate\View\MarkDown;
use kaluzki\Routing\Service;

/**
 */
class Api implements \IteratorAggregate
{
    /**
     * @var string[]
     */
    protected $scope;

    /**
     * @param array $scope
     */
    public function __construct(array $scope = [])
    {
        $this->scope = $scope;
    }

    /**
     * @return Model\TemplateSet[]
     */
    public function getSets()
    {
        $stores = [];
        foreach ($this->scope as $file) {
            $stores[$file] = (new Model\XmlStore(simplexml_load_file($file)))->getIterator();
        }
        return $stores;
    }

    /**
     * @param string $group
     *
     * @return Model\TemplateSet
     *
     * @throws \RuntimeException
     */
    public function getSet($group)
    {
        foreach ($this->getSets() as $set) {
            if ($set->group == $group) {
                return $set;
            }
        }
        throw new \RuntimeException("Template set with group='$group' not found");
    }

    /**
     * @param string $group
     * @param string $templateName
     *
     * @return Model\Template
     *
     * @throws \RuntimeException
     */
    public function getTemplate($group, $templateName)
    {
        foreach ($this->getSet($group)->templates as $template) {
            if ($template->name == $templateName) {
                return $template;
            }
        }
        throw new \RuntimeException("Template with name='$templateName' not found");
    }

    /**
     * @param string $group
     * @param string $templateName
     * @param string $variableName
     *
     * @return Model\Variable
     *
     * @throws \RuntimeException
     */
    public function getVariable($group, $templateName, $variableName)
    {
        foreach ($this->getTemplate($group, $templateName)->variables as $variable) {
            if ($variable->name == $variableName) {
                return $variable;
            }
        }
        throw new \RuntimeException("Variable with name='$variableName' not found");
    }

    /**
     * @param Model\AbstractEntity|Model\AbstractEntity[] $entity
     * @param string $format
     *
     * @return string
     */
    protected function format($entity, $format)
    {
        if (strtolower($format) == 'md') {
            $md = new MarkDown();
            return array_map(function(Model\AbstractEntity $entity) use($md) {
                if ($entity instanceof Model\TemplateSet) {
                    return $md->render($entity);
                } else if ($entity instanceof Model\Template) {
                    return $md->renderTemplate($entity);
                } else if ($entity instanceof Model\Variable) {
                    return $md->renderVariable($entity);
                }
                return '';
            },  is_array($entity) ? $entity : [$entity]);
        }

        return json_encode($entity, JSON_PRETTY_PRINT);
    }

    /**
     * @param \Closure $closure
     *
     * @return Service
     */
    protected function service(\Closure $closure)
    {
        return new Service($closure, [
            'defaults'     => ['format' => 'json'],
            'requirements' => ['format' => 'json|md'],
        ]);
    }

    /**
     * @return \ArrayObject
     */
    public function getIterator()
    {
        $sets      = $this->service(function($format) {
            return $this->format($this->getSets(), $format);
        });

        $group     = $this->service(function($group, $format) {
            return $this->format($this->getSet($group), $format);
        });

        $templates = $this->service(function($group, $format) {
            return $this->format($this->getSet($group)->templates, $format);
        });

        $template  = $this->service(function($group, $template, $format) {
            return $this->format($this->getTemplate($group, $template), $format);
        });

        $variables = $this->service(function($group, $template, $format) {
            return $this->format($this->getTemplate($group, $template)->variables, $format);
        });

        $variable  = $this->service(function($group, $template, $variable, $format) {
            return $this->format($this->getVariable($group, $template, $variable), $format);
        });

        return new \ArrayObject([
            'GET /sets/{group}/templates/{template}/variables/{variable}.{format}' => $variable,
            'GET /sets/{group}/templates/{template}/variables/{variable}'          => $variable,
            'GET /sets/{group}/templates/{template}/variables.{format}'            => $variables,
            'GET /sets/{group}/templates/{template}/variables'                     => $variables,
            'GET /sets/{group}/templates/{template}.{format}'                      => $template,
            'GET /sets/{group}/templates/{template}'                               => $template,
            'GET /sets/{group}/templates.{format}'                                 => $templates,
            'GET /sets/{group}/templates'                                          => $templates,
            'GET /sets/{group}.{format}'                                           => $group,
            'GET /sets/{group}'                                                    => $group,
            'GET /sets.{format}'                                                   => $sets,
            'GET /sets'                                                            => $sets,
        ]);
    }
}