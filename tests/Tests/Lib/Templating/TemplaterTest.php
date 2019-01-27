<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 27/01/19
 * Time: 16:26.
 */

namespace Tests\Lib\Templating;

use Lib\Templating\Templater;
use Tests\TestCase;

class TemplaterTest extends TestCase
{
    /** @var Templater */
    private $templater;

    public function setUp()
    {
        $this->templater = new Templater();
    }

    public function testRender()
    {
        $render = $this->templater->render('index.html.twig');
        $this->assertContains('<h1>Default', $render);
    }
}
