<?php
use org\bovigo\vfs\vfsStream;

class ProxyJsonViewTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    public function setUp()
    {
        $this->root = vfsStream::setup('root');

        $this->controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $this->view = new ProxyJsonView($this->controller);
    }

    /**
     * @runInSeparateProcess
     */
    public function testRender()
    {
        define('VIEWS_DIR', vfsStream::url($this->root->getName()));

        $vFile = vfsStream::newFile('index.php');
        $vFile->setContent(
            <<<'EOF'
<?php
$response = array('name' => $name);
EOF
        );
        $this->root->addChild($vFile);

        $this->view->vars = array('name' => 'John Doe');
        $this->view->render('index');
        $this->assertJsonStringEqualsJsonString(
            json_encode(array('name' => 'John Doe')), $this->view->controller->output);
    }

    /**
     * @expectedException DCException
     * @expectedExceptionMessage unknown.php is not found
     */
    public function testDCExceptionOnRender()
    {
        $this->view->render('unknown');
    }
}
