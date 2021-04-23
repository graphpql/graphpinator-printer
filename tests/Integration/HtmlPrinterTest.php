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
                <section>
                    <div class="line">
                        <span class="description">"""<br>Int built-in type (32 bit)<br>"""<br></span>
                        <span class="keyword" id="graphql-type-Int">scalar</span>&nbsp;
                        <span class="typename">Int</span>
                    </div>
                </section>
                EOL,
            ],
            [
                new \Graphpinator\Introspection\TypeKind(),
                <<<'EOL'
                <section>
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection enum.<br>"""<br></span>
                        <span class="keyword" id="graphql-type-__TypeKind">enum</span>&nbsp;
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
                <section>
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection type.<br>"""<br></span>
                        <span class="keyword" id="graphql-type-__Schema">type</span>&nbsp;
                        <span class="typename">__Schema</span>
                        <span class="implements"></span>
                        <span class="usage"></span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    
                    <span class="field-name">description</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-String" title="String built-in type">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">types</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type."><span class="bracket-square">[</span>__Type<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">queryType</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type.">__Type<span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">mutationType</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">subscriptionType</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">directives</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Directive" title="Built-in introspection type."><span class="bracket-square">[</span>__Directive<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
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
                <section>
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection type.<br>"""<br></span>
                        <span class="keyword" id="graphql-type-__Type">type</span>&nbsp;
                        <span class="typename">__Type</span>
                        <span class="implements"></span>
                        <span class="usage"></span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    
                    <span class="field-name">kind</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__TypeKind" title="Built-in introspection enum.">__TypeKind<span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">name</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-String" title="String built-in type">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">description</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-String" title="String built-in type">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">fields</span>
                    <div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item">    
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <a class="argument-type" href="#graphql-type-Boolean" title="Boolean built-in type">Boolean<span class="exclamation-mark">!</span></a>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    </div></div><span class="bracket-round">)</span></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Field" title="Built-in introspection type."><span class="bracket-square">[</span>__Field<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">interfaces</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type."><span class="bracket-square">[</span>__Type<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">possibleTypes</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type."><span class="bracket-square">[</span>__Type<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">enumValues</span>
                    <div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item">    
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <a class="argument-type" href="#graphql-type-Boolean" title="Boolean built-in type">Boolean<span class="exclamation-mark">!</span></a>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    </div></div><span class="bracket-round">)</span></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__EnumValue" title="Built-in introspection type."><span class="bracket-square">[</span>__EnumValue<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">inputFields</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__InputValue" title="Built-in introspection type."><span class="bracket-square">[</span>__InputValue<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">ofType</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__Type" title="Built-in introspection type.">__Type</a>
                    
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
                <section>
                    <div class="line">
                        <span class="description">"""<br>Built-in introspection type.<br>"""<br></span>
                        <span class="keyword" id="graphql-type-__Directive">type</span>&nbsp;
                        <span class="typename">__Directive</span>
                        <span class="implements"></span>
                        <span class="usage"></span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    
                    <span class="field-name">name</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">description</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-String" title="String built-in type">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">locations</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__DirectiveLocation" title="Built-in introspection enum."><span class="bracket-square">[</span>__DirectiveLocation<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">args</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-__InputValue" title="Built-in introspection type."><span class="bracket-square">[</span>__InputValue<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    
                    <span class="field-name">isRepeatable</span>
                    <div class="arguments"></div>
                    <span class="colon">:</span>&nbsp;
                    <a class="field-type" href="#graphql-type-Boolean" title="Boolean built-in type">Boolean<span class="exclamation-mark">!</span></a>
                    
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
                <section>
                    <div class="line">
                        
                        <span class="keyword">schema</span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">query</span>
                        <span class="colon">:</span>&nbsp;
                        <a class="field-type" href="#graphql-type-Query" title="">Query</a>
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
                <section>
                    <div class="line">
                        <span class="description">"""<br>Schema description<br>"""<br></span>
                        <span class="keyword">schema</span>&nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">query</span>
                        <span class="colon">:</span>&nbsp;
                        <a class="field-type" href="#graphql-type-Query" title="">Query</a>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">mutation</span>
                        <span class="colon">:</span>&nbsp;
                        <a class="field-type" href="#graphql-type-Query" title="">Query</a>
                    </div>
                    <div class="line offset-1">
                        <span class="field-name">subscription</span>
                        <span class="colon">:</span>&nbsp;
                        <a class="field-type" href="#graphql-type-Query" title="">Query</a>
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
        <div class="graphpinator-schema"><section><div class="line"><span class="keyword">schema</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><span class="field-name">query</span><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-Query" title="">Query</a></div><div class="line offset-1"><span class="field-name">mutation</span><span class="colon">:</span>&nbsp;<span class="null">null</span></div><div class="line offset-1"><span class="field-name">subscription</span><span class="colon">:</span>&nbsp;<span class="null">null</span></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-ChildInterface">interface</span>&nbsp;<span class="typename">ChildInterface</span><span class="implements">&nbsp;implements&nbsp;<a class="typename" href="#graphql-type-ParentInterface" title="ParentInterface Description">ParentInterface</a></span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div></div><div class="item"><div class="line offset-1"><span class="field-name">number</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-Int" title="Int built-in type (32 bit)">Int<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-ChildType">type</span>&nbsp;<span class="typename">ChildType</span><span class="implements">&nbsp;implements&nbsp;<a class="typename" href="#graphql-type-ParentInterface" title="ParentInterface Description">ParentInterface</a>&nbsp;<span class="ampersand">&</span>&nbsp;<a class="typename" href="#graphql-type-ChildInterface" title="">ChildInterface</a>&nbsp;<span class="ampersand">&</span>&nbsp;<a class="typename" href="#graphql-type-SecondInterface" title="">SecondInterface</a></span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div></div><div class="item"><div class="line offset-1"><span class="field-name">number</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-Int" title="Int built-in type (32 bit)">Int<span class="exclamation-mark">!</span></a></div></div><div class="item"><div class="line offset-1"><span class="field-name">secondField</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="description">"""<br>ComplexDefaultsInput description<br>"""<br></span><span class="keyword" id="graphql-type-ComplexDefaultsInput">input</span>&nbsp;<span class="typename">ComplexDefaultsInput</span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="argument-name">name</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-String" title="String built-in type">String</a>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="">"default"</span></span></div><div class="item"><span class="argument-name">inner</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description">ComplexDefaultsInput</a>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span></span></div><div class="item"><span class="argument-name">innerList</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description"><span class="bracket-square">[</span>ComplexDefaultsInput<span class="bracket-square">]</span></a>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerList1"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerList2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-DescriptionEnum">enum</span>&nbsp;<span class="typename">DescriptionEnum</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="description">"single line description"<br></span><span class="enum-item line">A</span></div><br><div class="item"><span class="enum-item line">B&nbsp;<span class="typename">@deprecated</span></span></div><br><div class="item"><span class="description">"""<br>multi line<br>description<br>"""<br></span><span class="enum-item line">C</span></div><br><div class="item"><span class="description">"single line description"<br></span><span class="enum-item line">D&nbsp;<span class="typename">@deprecated</span><span class="bracket-round">(</span><span class="directive-usage-name">reason</span><span class="colon">:</span>&nbsp;<span class="directive-usage-value">"reason"</span><span class="bracket-round">)</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="description">"""<br>ParentInterface Description<br>"""<br></span><span class="keyword" id="graphql-type-ParentInterface">interface</span>&nbsp;<span class="typename">ParentInterface</span><span class="implements"></span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-Query">type</span>&nbsp;<span class="typename">Query</span><span class="implements"></span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">field1</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String</a></div></div><br><div class="item"><div class="line offset-1"><span class="description">"Description to field"<br></span><span class="field-name">fieldWithDescription</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String</a></div></div><br><div class="item"><div class="line offset-1"><span class="field-name">field2</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String</a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SecondInterface">interface</span>&nbsp;<span class="typename">SecondInterface</span><span class="implements"></span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">secondField</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleEnum">enum</span>&nbsp;<span class="typename">SimpleEnum</span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="enum-item line">A</span></div><div class="item"><span class="enum-item line">B</span></div><div class="item"><span class="enum-item line">C</span></div><div class="item"><span class="enum-item line">D</span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleInput">input</span>&nbsp;<span class="typename">SimpleInput</span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line offset-1"><div class="item"><span class="argument-name">name</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div><div class="item"><span class="argument-name">number</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-Int" title="Int built-in type (32 bit)"><span class="bracket-square">[</span>Int<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a></div><div class="item"><span class="argument-name">bool</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-Boolean" title="Boolean built-in type">Boolean</a></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleScalar">scalar</span>&nbsp;<span class="typename">SimpleScalar</span></div></section><section><div class="line"><span class="description">"""<br>Description for SimpleType<br>"""<br></span><span class="keyword" id="graphql-type-SimpleType">type</span>&nbsp;<span class="typename">SimpleType</span><span class="implements"></span><span class="usage"></span>&nbsp;<span class="bracket-curly">{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="field-name">name</span><div class="arguments"></div><span class="colon">:</span>&nbsp;<a class="field-type" href="#graphql-type-String" title="String built-in type">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleUnion">union</span>&nbsp;<span class="typename">SimpleUnion&nbsp;<span class="equals">=</span>&nbsp;<a class="union-type" href="#graphql-type-SimpleType" title="Description for SimpleType">SimpleType</a>&nbsp;<span class="vertical-line">|</span>&nbsp;<a class="union-type" href="#graphql-type-ChildType" title="">ChildType</a></span></div></section><section><div class="line"><span class="keyword" id="graphql-type-simpleDirective">directive</span>&nbsp;<span class="typename">@simpleDirective</span><span class="bracket-round">(</span><div class="line offset-1"><div class="item"><span class="argument-name">reason</span><span class="colon">:</span>&nbsp;<a class="argument-type" href="#graphql-type-String" title="String built-in type">String</a></div></div><span class="bracket-round">)</span>&nbsp;<span class="keyword">repeatable</span>&nbsp;<span class="keyword">on</span>&nbsp;<span class="location">FIELD&nbsp;<span class="vertical-line">|</span>&nbsp;INLINE_FRAGMENT&nbsp;<span class="vertical-line">|</span>&nbsp;FRAGMENT_SPREAD</span></div></section></div>
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
