<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

final class HtmlPrinterTest extends \PHPUnit\Framework\TestCase
{
    public function simpleDataProvider() : array
    {
        $container = new \Graphpinator\Container\SimpleContainer([], []);

        return [
            [
                \Graphpinator\Container\Container::Int(),
                <<<'EOL'
                <section id="graphql-type-Int">
                    <div class="line">
                        <span class="description">"""<br>Int built-in type (32 bit)<br>"""<br></span>
                        <span class="keyword">scalar</span>&nbsp;
                        <span class="typename">Int</span>
                    </div>
                </section>
                EOL,
            ],
            [
                new \Graphpinator\Introspection\TypeKind(),
                <<<'EOL'
                <section id="graphql-type-__TypeKind">
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection enum.<br>"""<br></span>
                        <span class="keyword">enum</span>&nbsp;
                        <span class="typename">__TypeKind</span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <div class="item"><span class="enum-item line">SCALAR</span></div><div class="item"><span class="enum-item line">OBJECT</span></div><div class="item"><span class="enum-item line">INTERFACE</span></div><div class="item"><span class="enum-item line">UNION</span></div><div class="item"><span class="enum-item line">ENUM</span></div><div class="item"><span class="enum-item line">INPUT_OBJECT</span></div><div class="item"><span class="enum-item line">LIST</span></div><div class="item"><span class="enum-item line">NON_NULL</span></div>
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
            [
                new \Graphpinator\Introspection\Schema($container),
                <<<'EOL'
                <section id="graphql-type-__Schema">
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection type.<br>"""<br></span>
                        <span class="keyword">type</span>&nbsp;
                        <span class="typename">__Schema</span>
                        
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    
                    <span class="field-name">description</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">types</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">queryType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a><span class="exclamation-mark">!</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">mutationType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">subscriptionType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">directives</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Directive" title="Built-in introspection type.">__Directive</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div></div>
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
            [
                new \Graphpinator\Introspection\Type($container),
                <<<'EOL'
                <section id="graphql-type-__Type">
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection type.<br>"""<br></span>
                        <span class="keyword">type</span>&nbsp;
                        <span class="typename">__Type</span>
                        
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    
                    <span class="field-name">kind</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__TypeKind" title="Built-in introspection enum.">__TypeKind</a><span class="exclamation-mark">!</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">name</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">description</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">fields</span>
                    <div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item">    
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    </div></div><span class="bracket-round">)</span></div>
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Field" title="Built-in introspection type.">__Field</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">interfaces</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">possibleTypes</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">enumValues</span>
                    <div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item">    
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    </div></div><span class="bracket-round">)</span></div>
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__EnumValue" title="Built-in introspection type.">__EnumValue</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">inputFields</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__InputValue" title="Built-in introspection type.">__InputValue</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">ofType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a></span>
                    
                </div></div>
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
            [
                new \Graphpinator\Introspection\Directive($container),
                <<<'EOL'
                <section id="graphql-type-__Directive">
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection type.<br>"""<br></span>
                        <span class="keyword">type</span>&nbsp;
                        <span class="typename">__Directive</span>
                        
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    
                    <span class="field-name">name</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">description</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">locations</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__DirectiveLocation" title="Built-in introspection enum.">__DirectiveLocation</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">args</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__InputValue" title="Built-in introspection type.">__InputValue</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">isRepeatable</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    
                </div></div>
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
            [
                TestSchema::getSchema(),
                <<<'EOL'
                <section id="graphql-schema" class="section-schema">
                    <div class="line">
                        
                        <span class="keyword">schema</span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">query</span>
                        <span class="colon">:</span>&nbsp;
                        <span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">mutation</span>
                        <span class="colon">:</span>&nbsp;
                        <span class="null">null</span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">subscription</span>
                        <span class="colon">:</span>&nbsp;
                        <span class="null">null</span>
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
            [
                TestSchema::getFullSchema()->setDescription('Schema description'),
                <<<'EOL'
                <section id="graphql-schema" class="section-schema">
                    <div class="line">
                        <span class="description">"""<br>Schema description<br>"""<br></span>
                        <span class="keyword">schema</span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">query</span>
                        <span class="colon">:</span>&nbsp;
                        <span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">mutation</span>
                        <span class="colon">:</span>&nbsp;
                        <span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">subscription</span>
                        <span class="colon">:</span>&nbsp;
                        <span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
        ];
    }

    /**
     * @dataProvider simpleDataProvider
     * @param \Graphpinator\Type\Contract\Definition $type
     * @param string $print
     */
    public function testSimple(\Graphpinator\Typesystem\Entity $type, string $print) : void
    {
        $visitor = new \Graphpinator\Printer\HtmlVisitor();
        self::assertSame($print, $type->accept($visitor));
    }

    public function testPrintSchema() : void
    {
        $expected = <<<'EOL'
        <div class="graphpinator-schema"><section id="graphql-schema" class="section-schema"><div class="line"><span class="keyword">schema</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><span class="field-name">query</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span></div><div class="line offset-1"><span class="field-name">mutation</span><span class="colon">:</span>&nbsp;<span class="null">null</span></div><div class="line offset-1"><span class="field-name">subscription</span><span class="colon">:</span>&nbsp;<span class="null">null</span></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-ChildInterface"><div class="line"><span class="keyword">interface</span>&nbsp;<span class="typename">ChildInterface</span>&nbsp;<span class="keyword">implements</span>&nbsp;<a class="typename" href="#graphql-type-ParentInterface" title="ParentInterface Description">ParentInterface</a>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div><div class="item"><div class="line offset-1"><span class="field-name">number</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="Int built-in type (32 bit)">Int</a><span class="exclamation-mark">!</span></span></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-ChildType"><div class="line"><span class="keyword">type</span>&nbsp;<span class="typename">ChildType</span>&nbsp;<span class="keyword">implements</span>&nbsp;<a class="typename" href="#graphql-type-ParentInterface" title="ParentInterface Description">ParentInterface</a>&nbsp;<span class="ampersand">&</span>&nbsp;<a class="typename" href="#graphql-type-ChildInterface" title="">ChildInterface</a>&nbsp;<span class="ampersand">&</span>&nbsp;<a class="typename" href="#graphql-type-SecondInterface" title="">SecondInterface</a>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div><div class="item"><div class="line offset-1"><span class="field-name">number</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="Int built-in type (32 bit)">Int</a><span class="exclamation-mark">!</span></span></div></div><div class="item"><div class="line offset-1"><span class="field-name">secondField</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-ComplexDefaultsInput"><div class="line"><span class="description">"""<br>ComplexDefaultsInput description<br>"""<br></span><span class="keyword">input</span>&nbsp;<span class="typename">ComplexDefaultsInput</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="argument-name">name</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="String built-in type">String</a></span>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="string-literal">"default"</span></span></div><div class="item"><span class="argument-name">inner</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename" href="#graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description">ComplexDefaultsInput</a></span>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span></span></div><div class="item"><span class="argument-name">innerList</span><span class="colon">:</span>&nbsp;<span class="argument-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description">ComplexDefaultsInput</a><span class="bracket-square">]</span></span>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerList1"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerList2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-DescriptionEnum"><div class="line"><span class="keyword">enum</span>&nbsp;<span class="typename">DescriptionEnum</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="description">"single line description"<br></span><span class="enum-item line">A</span></div><br><div class="item"><span class="enum-item line">B&nbsp;<span class="typename"><a class="typename"  title="Built-in deprecated directive.">@deprecated</a></span></span></div><br><div class="item"><span class="description">"""<br>multi line<br>description<br>"""<br></span><span class="enum-item line">C</span></div><br><div class="item"><span class="description">"single line description"<br></span><span class="enum-item line">D&nbsp;<span class="typename"><a class="typename"  title="Built-in deprecated directive.">@deprecated</a></span><span class="bracket-round">(</span><span class="argument-name">reason</span><span class="colon">:</span>&nbsp;<span class="argument-value"><span class="string-literal">"reason"</span></span><span class="bracket-round">)</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-ParentInterface"><div class="line"><span class="description">"""<br>ParentInterface Description<br>"""<br></span><span class="keyword">interface</span>&nbsp;<span class="typename">ParentInterface</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-Query"><div class="line"><span class="keyword">type</span>&nbsp;<span class="typename">Query</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">field1</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a></span></div></div><br><div class="item"><div class="line offset-1"><span class="description">"Description to field"<br></span><span class="field-name">fieldWithDescription</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a></span></div></div><br><div class="item"><div class="line offset-1"><span class="field-name">field2</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a></span></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-SecondInterface"><div class="line"><span class="keyword">interface</span>&nbsp;<span class="typename">SecondInterface</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">secondField</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-SimpleEnum"><div class="line"><span class="keyword">enum</span>&nbsp;<span class="typename">SimpleEnum</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="enum-item line">A</span></div><div class="item"><span class="enum-item line">B</span></div><div class="item"><span class="enum-item line">C</span></div><div class="item"><span class="enum-item line">D</span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-SimpleInput"><div class="line"><span class="keyword">input</span>&nbsp;<span class="typename">SimpleInput</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="argument-name">name</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div><div class="item"><span class="argument-name">number</span><span class="colon">:</span>&nbsp;<span class="argument-type"><span class="bracket-square">[</span><a class="typename"  title="Int built-in type (32 bit)">Int</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span></div><div class="item"><span class="argument-name">bool</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-SimpleScalar"><div class="line"><span class="keyword">scalar</span>&nbsp;<span class="typename">SimpleScalar</span></div></section><section id="graphql-type-SimpleType"><div class="line"><span class="description">"""<br>Description for SimpleType<br>"""<br></span><span class="keyword">type</span>&nbsp;<span class="typename">SimpleType</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section id="graphql-type-SimpleUnion"><div class="line"><span class="keyword">union</span>&nbsp;<span class="typename">SimpleUnion&nbsp;<span class="equals">=</span>&nbsp;<span class="union-type"><a class="typename" href="#graphql-type-SimpleType" title="Description for SimpleType">SimpleType</a></span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="union-type"><a class="typename" href="#graphql-type-ChildType" title="">ChildType</a></span></span></div></section><section id="graphql-directive-simpleDirective"><div class="line"><span class="keyword">directive</span>&nbsp;<span class="typename">@simpleDirective</span><div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item"><span class="argument-name">reason</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="String built-in type">String</a></span></div></div><span class="bracket-round">)</span></div>&nbsp;<span class="keyword">repeatable</span>&nbsp;<span class="keyword">on</span>&nbsp;<span class="enum-literal">FIELD</span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="enum-literal">INLINE_FRAGMENT</span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="enum-literal">FRAGMENT_SPREAD</span></div></section></div>
        EOL;

        $printer = new \Graphpinator\Printer\Printer(
            new \Graphpinator\Printer\HtmlVisitor(),
        );

        self::assertSame($expected, $printer->printSchema(TestSchema::getSchema()));
    }

    public function testValidateCorrectOrder() : void
    {
        $expected = [
            'interface</span>&nbsp;<span class="typename">ChildInterface</span>',
            'interface</span>&nbsp;<span class="typename">ParentInterface</span>',
            'interface</span>&nbsp;<span class="typename">SecondInterface</span>',
            'type</span>&nbsp;<span class="typename">ChildType</span>',
            'type</span>&nbsp;<span class="typename">SimpleType</span>',
            'union</span>&nbsp;<span class="typename">SimpleUnion',
            'input</span>&nbsp;<span class="typename">ComplexDefaultsInput</span>',
            'input</span>&nbsp;<span class="typename">SimpleInput</span>',
            'enum</span>&nbsp;<span class="typename">DescriptionEnum</span>',
            'enum</span>&nbsp;<span class="typename">SimpleEnum</span>',
            'directive</span>&nbsp;<span class="typename">@simpleDirective</span>',
        ];

        $printer = new \Graphpinator\Printer\Printer(
            new \Graphpinator\Printer\HtmlVisitor(),
            new \Graphpinator\Printer\TypeKindSorter(),
        );
        $schema = $printer->printSchema(TestSchema::getSchema());
        $lastCheckedPos = 0;

        foreach ($expected as $type) {
            $pos = \strpos($schema, $type);
            self::assertGreaterThan($lastCheckedPos, $pos);
            $lastCheckedPos = $pos;
        }
    }
}
