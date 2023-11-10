<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

//@phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
final class HtmlPrinterTest extends \PHPUnit\Framework\TestCase
{
    public static function simpleDataProvider() : array
    {
        $container = new \Graphpinator\SimpleContainer([], []);

        return [
            [
                \Graphpinator\Typesystem\Container::Int(),
                <<<'EOL'
                <section id="graphql-type-Int">
                    <div class="description">
                    <div class="line">"""</div>
                    <div class="line">Int built-in type (32 bit)</div>
                    <div class="line">"""</div>
                </div>
                    <div class="line">
                        <a href="#graphql-type-Int" class="self-link">
                            <span class="keyword">scalar</span>&nbsp;
                            <span class="typename">Int</span>
                        </a>
                        
                    </div>
                </section>
                EOL,
            ],
            [
                new \Graphpinator\Introspection\TypeKind(),
                <<<'EOL'
                <section id="graphql-type-__TypeKind">
                    <div class="description">
                    <div class="line">"""</div>
                    <div class="line">Built-in introspection type</div>
                    <div class="line">"""</div>
                </div>
                    <div class="line">
                        <a href="#graphql-type-__TypeKind" class="self-link">
                            <span class="keyword">enum</span>&nbsp;
                            <span class="typename">__TypeKind</span>
                        </a>
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="offset">
                        <div class="line enum-item">SCALAR</div><div class="line enum-item">OBJECT</div><div class="line enum-item">INTERFACE</div><div class="line enum-item">UNION</div><div class="line enum-item">ENUM</div><div class="line enum-item">INPUT_OBJECT</div><div class="line enum-item">LIST</div><div class="line enum-item">NON_NULL</div>
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
                    <div class="description">
                    <div class="line">"""</div>
                    <div class="line">Built-in introspection type</div>
                    <div class="line">"""</div>
                </div>
                    <div class="line">
                        <a href="#graphql-type-__Schema" class="self-link">
                            <span class="keyword">type</span>&nbsp;
                            <span class="typename">__Schema</span>
                        </a>
                        
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="offset">
                        
                <div class="line">
                    <span class="field-name">description</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">types</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">queryType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a><span class="exclamation-mark">!</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">mutationType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">subscriptionType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">directives</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Directive" title="Built-in introspection type">__Directive</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div>
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
                    <div class="description">
                    <div class="line">"""</div>
                    <div class="line">Built-in introspection type</div>
                    <div class="line">"""</div>
                </div>
                    <div class="line">
                        <a href="#graphql-type-__Type" class="self-link">
                            <span class="keyword">type</span>&nbsp;
                            <span class="typename">__Type</span>
                        </a>
                        
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="offset">
                        
                <div class="line">
                    <span class="field-name">kind</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__TypeKind" title="Built-in introspection type">__TypeKind</a><span class="exclamation-mark">!</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">name</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">description</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">fields</span>
                        <span class="bracket-round">(</span>
                </div>
                <div class="offset">
                    
                <div class="line">
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    
                </div>
                </div>
                <div class="line">
                    <span class="bracket-round">)</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Field" title="Built-in introspection type">__Field</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">interfaces</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">possibleTypes</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">enumValues</span>
                        <span class="bracket-round">(</span>
                </div>
                <div class="offset">
                    
                <div class="line">
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    
                </div>
                </div>
                <div class="line">
                    <span class="bracket-round">)</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__EnumValue" title="Built-in introspection type">__EnumValue</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">inputFields</span>
                        <span class="bracket-round">(</span>
                </div>
                <div class="offset">
                    
                <div class="line">
                    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    &nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="false">false</span></span>
                    
                </div>
                </div>
                <div class="line">
                    <span class="bracket-round">)</span>
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__InputValue" title="Built-in introspection type">__InputValue</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">ofType</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename" href="#graphql-type-__Type" title="Built-in introspection type">__Type</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">specifiedByURL</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">isOneOf</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="Boolean built-in type">Boolean</a></span>
                    
                </div>
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
                    <div class="description">
                    <div class="line">"""</div>
                    <div class="line">Built-in introspection type</div>
                    <div class="line">"""</div>
                </div>
                    <div class="line">
                        <a href="#graphql-type-__Directive" class="self-link">
                            <span class="keyword">type</span>&nbsp;
                            <span class="typename">__Directive</span>
                        </a>
                        
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="offset">
                        
                <div class="line">
                    <span class="field-name">name</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">description</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="String built-in type">String</a></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">locations</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__DirectiveLocation" title="Built-in introspection type">__DirectiveLocation</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">args</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-__InputValue" title="Built-in introspection type">__InputValue</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span>
                    
                </div>
                <div class="line">
                    <span class="field-name">isRepeatable</span>
                    
                    <span class="colon">:</span>&nbsp;
                    <span class="field-type"><a class="typename"  title="Boolean built-in type">Boolean</a><span class="exclamation-mark">!</span></span>
                    
                </div>
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
                <section id="graphql-schema">
                    
                    <div class="line">
                        <a href="#graphql-schema" class="self-link">
                            <span class="keyword">schema</span>
                        </a>
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="offset">
                        <div class="line">
                            <span class="field-name">query</span>
                            <span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                        </div>
                        
                        
                    </div>
                    <div class="line">
                        <span class="bracket-curly">}</span>
                    </div>
                </section>
                EOL,
            ],
            [
                TestSchema::getFullSchema()->setDescription(<<<'EOL'
                Multiline
                
                schema
                
                description
                    indent
                EOL),
                <<<'EOL'
                <section id="graphql-schema">
                    <div class="description">
                    <div class="line">"""</div>
                    <div class="line">Multiline</div><div class="line">&nbsp;</div><div class="line">schema</div><div class="line">&nbsp;</div><div class="line">description</div><div class="line">    indent</div>
                    <div class="line">"""</div>
                </div>
                    <div class="line">
                        <a href="#graphql-schema" class="self-link">
                            <span class="keyword">schema</span>
                        </a>
                        &nbsp;
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="offset">
                        <div class="line">
                            <span class="field-name">query</span>
                            <span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                        </div>
                        <div class="line">
                            <span class="field-name">mutation</span>
                            <span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                        </div>
                        <div class="line">
                            <span class="field-name">subscription</span>
                            <span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span>
                        </div>
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
     * @param \Graphpinator\Typesystem\Entity $type
     * @param string $print
     */
    public function testSimple(\Graphpinator\Typesystem\Contract\Entity $type, string $print) : void
    {
        $visitor = new \Graphpinator\Printer\HtmlVisitor();
        self::assertSame($print, $type->accept($visitor));
    }

    public function testPrintSchema() : void
    {
        $expected = <<<'EOL'
        <div class="graphpinator-schema"><div class="floating-container"><a class="floating-button" href="#graphql-schema" title="Go to top">&uarr;</a><a class="floating-button" href="#graphql-type-Query" title="Go to query root type">Q</a></div><div class="code"><section id="graphql-schema"><div class="line"><a href="#graphql-schema" class="self-link"><span class="keyword">schema</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">query</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename" href="#graphql-type-Query" title="">Query</a></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-ChildInterface"><div class="line"><a href="#graphql-type-ChildInterface" class="self-link"><span class="keyword">interface</span>&nbsp;<span class="typename">ChildInterface</span></a>&nbsp;<span class="keyword">implements</span>&nbsp;<a class="typename" href="#graphql-type-ParentInterface" title="ParentInterface Description">ParentInterface</a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div><div class="line"><span class="field-name">number</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="Int built-in type (32 bit)">Int</a><span class="exclamation-mark">!</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-ChildType"><div class="line"><a href="#graphql-type-ChildType" class="self-link"><span class="keyword">type</span>&nbsp;<span class="typename">ChildType</span></a>&nbsp;<span class="keyword">implements</span>&nbsp;<a class="typename" href="#graphql-type-ParentInterface" title="ParentInterface Description">ParentInterface</a>&nbsp;<span class="ampersand">&</span>&nbsp;<a class="typename" href="#graphql-type-ChildInterface" title="">ChildInterface</a>&nbsp;<span class="ampersand">&</span>&nbsp;<a class="typename" href="#graphql-type-SecondInterface" title="">SecondInterface</a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div><div class="line"><span class="field-name">number</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="Int built-in type (32 bit)">Int</a><span class="exclamation-mark">!</span></span></div><div class="line"><span class="field-name">secondField</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-ComplexDefaultsInput"><div class="description"><div class="line">"""</div><div class="line">ComplexDefaultsInput description</div><div class="line">"""</div></div><div class="line"><a href="#graphql-type-ComplexDefaultsInput" class="self-link"><span class="keyword">input</span>&nbsp;<span class="typename">ComplexDefaultsInput</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="argument-name">name</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="String built-in type">String</a></span>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="string-literal">"default"</span></span></div><div class="line"><span class="argument-name">inner</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename" href="#graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description">ComplexDefaultsInput</a></span>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span></span></div><div class="line"><span class="argument-name">innerList</span><span class="colon">:</span>&nbsp;<span class="argument-type"><span class="bracket-square">[</span><a class="typename" href="#graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description">ComplexDefaultsInput</a><span class="bracket-square">]</span></span>&nbsp;<span class="equals">=</span>&nbsp;<span class="argument-value"><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerList1"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"innerList2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="string-literal">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-DescriptionEnum"><div class="line"><a href="#graphql-type-DescriptionEnum" class="self-link"><span class="keyword">enum</span>&nbsp;<span class="typename">DescriptionEnum</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="description"><div class="line">"single line description"</div></div><div class="line enum-item">A</div><div class="line">&nbsp;</div><div class="line enum-item">B&nbsp;<span class="typename"><a class="typename"  title="Built-in deprecated directive">@deprecated</a></span></div><div class="line">&nbsp;</div><div class="description"><div class="line">"""</div><div class="line">multi line</div><div class="line">description</div><div class="line">"""</div></div><div class="line enum-item">C</div><div class="line">&nbsp;</div><div class="description"><div class="line">"single line description"</div></div><div class="line enum-item">D&nbsp;<span class="typename"><a class="typename"  title="Built-in deprecated directive">@deprecated</a></span><span class="bracket-round">(</span><span class="argument-name">reason</span><span class="colon">:</span>&nbsp;<span class="argument-value"><span class="string-literal">"reason"</span></span><span class="bracket-round">)</span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-ParentInterface"><div class="description"><div class="line">"""</div><div class="line">ParentInterface Description</div><div class="line">"""</div></div><div class="line"><a href="#graphql-type-ParentInterface" class="self-link"><span class="keyword">interface</span>&nbsp;<span class="typename">ParentInterface</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-Query"><div class="line"><a href="#graphql-type-Query" class="self-link"><span class="keyword">type</span>&nbsp;<span class="typename">Query</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">field1</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a></span></div><div class="line">&nbsp;</div><div class="description"><div class="line">"Description to field"</div></div><div class="line"><span class="field-name">fieldWithDescription</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a></span></div><div class="line">&nbsp;</div><div class="line"><span class="field-name">field2</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-SecondInterface"><div class="line"><a href="#graphql-type-SecondInterface" class="self-link"><span class="keyword">interface</span>&nbsp;<span class="typename">SecondInterface</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">secondField</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-SimpleEnum"><div class="line"><a href="#graphql-type-SimpleEnum" class="self-link"><span class="keyword">enum</span>&nbsp;<span class="typename">SimpleEnum</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line enum-item">A</div><div class="line enum-item">B</div><div class="line enum-item">C</div><div class="line enum-item">D</div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-SimpleInput"><div class="line"><a href="#graphql-type-SimpleInput" class="self-link"><span class="keyword">input</span>&nbsp;<span class="typename">SimpleInput</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="argument-name">name</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div><div class="line"><span class="argument-name">number</span><span class="colon">:</span>&nbsp;<span class="argument-type"><span class="bracket-square">[</span><a class="typename"  title="Int built-in type (32 bit)">Int</a><span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></span></div><div class="line"><span class="argument-name">bool</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="Boolean built-in type">Boolean</a></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-SimpleScalar"><div class="line"><a href="#graphql-type-SimpleScalar" class="self-link"><span class="keyword">scalar</span>&nbsp;<span class="typename">SimpleScalar</span></a></div></section><div class="line">&nbsp;</div><section id="graphql-type-SimpleType"><div class="description"><div class="line">"""</div><div class="line">Description for SimpleType</div><div class="line">"""</div></div><div class="line"><a href="#graphql-type-SimpleType" class="self-link"><span class="keyword">type</span>&nbsp;<span class="typename">SimpleType</span></a>&nbsp;<span class="bracket-curly">{</span></div><div class="offset"><div class="line"><span class="field-name">name</span><span class="colon">:</span>&nbsp;<span class="field-type"><a class="typename"  title="String built-in type">String</a><span class="exclamation-mark">!</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><div class="line">&nbsp;</div><section id="graphql-type-SimpleUnion"><div class="line"><a href="#graphql-type-SimpleUnion" class="self-link"><span class="keyword">union</span>&nbsp;<span class="typename">SimpleUnion</span></a>&nbsp;<span class="equals">=</span>&nbsp;<span class="union-type"><a class="typename" href="#graphql-type-SimpleType" title="Description for SimpleType">SimpleType</a></span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="union-type"><a class="typename" href="#graphql-type-ChildType" title="">ChildType</a></span></div></section><div class="line">&nbsp;</div><section id="graphql-directive-simpleDirective"><div class="line"><a href="#graphql-directive-simpleDirective" class="self-link"><span class="keyword">directive</span>&nbsp;<span class="typename">@simpleDirective</span></a><span class="bracket-round">(</span></div><div class="offset"><div class="line"><span class="argument-name">reason</span><span class="colon">:</span>&nbsp;<span class="argument-type"><a class="typename"  title="String built-in type">String</a></span></div></div><div class="line"><span class="bracket-round">)</span>&nbsp;<span class="keyword">repeatable</span>&nbsp;<span class="keyword">on</span>&nbsp;<span class="enum-literal">FIELD</span></div></section></div></div>
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
