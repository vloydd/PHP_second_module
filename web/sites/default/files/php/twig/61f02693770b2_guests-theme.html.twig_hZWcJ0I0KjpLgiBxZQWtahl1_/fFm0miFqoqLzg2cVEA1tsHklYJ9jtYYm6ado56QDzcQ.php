<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/guests/templates/guests-theme.html.twig */
class __TwigTemplate_f023c4ceb4d135496f757f5f77e6fac58cbdad27447e6108a86f578bbe121786 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("guests/guests_libraries"), "html", null, true);
        echo "
<h2 class=\"form_message_intro\">Heey! You Can Add Here Your Review!</h2>
";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["form"] ?? null), 3, $this->source), "html", null, true);
        echo "
";
        // line 4
        if (($context["guests"] ?? null)) {
            // line 5
            echo "  <h2 class=\"form_message_intro\">Previous Reviews</h2>
";
        }
        // line 7
        echo "  <div class=\"guest_table-wrapper\">
    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["guests"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["items"]) {
            // line 9
            echo "      <div class=\"guest_table\">
        <div class=\"guest_table-basic\">
          <div class=\"guest_table-publishedByOn\">
            <p class=\"guest_table-publishedByOn-title\">Published by: </p>
              <ul class=\"guest_table-publishedByOn-list\">
                <li>
                  <p class=\"guest_name guest_item\">";
            // line 15
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "name", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
            echo "</p>
                </li>
                <li>
                  <a class=\"guest_email guest_item\" href=\"mailto:";
            // line 18
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "email", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "email", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
            echo "</a>
                </li>
                <li>
                  <a class=\"guest_phone guest_item\" href=\"callto:";
            // line 21
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "phone", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "phone", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
            echo "</a>
                </li>
              </ul>
          </div>
          ";
            // line 25
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "avatar", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
            echo "
          <div class=\"guest_table-publishedByOn\">
            <p class=\"guest_table-publishedByOn-title\">Published On: </p>
            <ul class=\"guest_table-publishedByOn-list\">
              <li><p class=\"guest_time guest_item\">";
            // line 29
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "time", [], "any", false, false, true, 29), 29, $this->source), "html", null, true);
            echo "</p></li>
            </ul>
          </div>
        </div>
        <div class=\"guest_table-main\">
          <div class=\"guest_review-wrapper guest_item\">
            <p class=\"guest_review guest_review-item guest_item\">";
            // line 35
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "review", [], "any", false, false, true, 35), 35, $this->source), "html", null, true);
            echo "</p>
          </div>
          <a class=\"vloyd_photo guest_item\" target=\"_blank\" href=\"";
            // line 37
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "photo_url", [], "any", false, false, true, 37), 37, $this->source), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "photo", [], "any", false, false, true, 37), 37, $this->source), "html", null, true);
            echo "</a>
        </div>
        ";
            // line 39
            if (twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "hasPermission", [0 => "administer nodes"], "method", false, false, true, 39)) {
                // line 40
                echo "          <div class=\"guest_table-edit-delete\">
            ";
                // line 41
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "edit", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
                echo "
            ";
                // line 42
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["items"], "delete", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
                echo "
          </div>
        ";
            }
            // line 45
            echo "      </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['items'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "  </div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/guests/templates/guests-theme.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  142 => 47,  135 => 45,  129 => 42,  125 => 41,  122 => 40,  120 => 39,  113 => 37,  108 => 35,  99 => 29,  92 => 25,  83 => 21,  75 => 18,  69 => 15,  61 => 9,  57 => 8,  54 => 7,  50 => 5,  48 => 4,  44 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/guests/templates/guests-theme.html.twig", "/var/www/web/modules/custom/guests/templates/guests-theme.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 4, "for" => 8);
        static $filters = array("escape" => 1);
        static $functions = array("attach_library" => 1);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape'],
                ['attach_library']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
