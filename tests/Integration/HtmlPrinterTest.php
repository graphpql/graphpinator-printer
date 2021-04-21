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
                        <span class="keyword" id="graphql-type-Int" title="Int built-in type (32 bit)">scalar&nbsp;</span>
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
                        <span class="keyword" id="graphql-type-__TypeKind" title="Built-in introspection enum.">enum&nbsp;</span>
                        <span class="typename">__TypeKind</span>
                        <span class="bracket-curly">&nbsp;{</span>
                    </div>
                    <div class="line offset-1">
                        <div class="item">    <span class="enumitem line" title="">SCALAR</span></div><div class="item">    <span class="enumitem line" title="">OBJECT</span></div><div class="item">    <span class="enumitem line" title="">INTERFACE</span></div><div class="item">    <span class="enumitem line" title="">UNION</span></div><div class="item">    <span class="enumitem line" title="">ENUM</span></div><div class="item">    <span class="enumitem line" title="">INPUT_OBJECT</span></div><div class="item">    <span class="enumitem line" title="">LIST</span></div><div class="item">    <span class="enumitem line" title="">NON_NULL</span></div>
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
                        <span class="keyword" id="graphql-type-__Schema" title="Built-in introspection type.">type&nbsp;</span>
                        <span class="typename">__Schema</span>
                        <span class="implements"></span>
                        <span class="usage"></span>
                        <span class="bracket-curly">&nbsp;{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-description">description</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-String" title="">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-types">types</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title=""><span class="bracket-square">[</span>__Type<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-queryType">queryType</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title="">__Type<span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-mutationType">mutationType</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title="">__Type</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-subscriptionType">subscriptionType</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title="">__Type</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-directives">directives</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Directive" title=""><span class="bracket-square">[</span>__Directive<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
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
                        <span class="keyword" id="graphql-type-__Type" title="Built-in introspection type.">type&nbsp;</span>
                        <span class="typename">__Type</span>
                        <span class="implements"></span>
                        <span class="usage"></span>
                        <span class="bracket-curly">&nbsp;{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-kind">kind</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__TypeKind" title="">__TypeKind<span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-name">name</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-String" title="">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-description">description</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-String" title="">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-fields">fields</span>
                    <div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item">    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:&nbsp;</span>
                    <a class="argument-type" href="#graphql-type-Boolean">Boolean<span class="exclamation-mark">!</span></a>
                    <span class="equals">&nbsp;=&nbsp;</span><span class="argument-value">        <span class="false">false</span></span>
                    </div></div><span class="bracket-round">)</span></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Field" title=""><span class="bracket-square">[</span>__Field<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-interfaces">interfaces</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title=""><span class="bracket-square">[</span>__Type<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-possibleTypes">possibleTypes</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title=""><span class="bracket-square">[</span>__Type<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-enumValues">enumValues</span>
                    <div class="arguments"><span class="bracket-round">(</span><div class="line offset-1"><div class="item">    <span class="argument-name">includeDeprecated</span>
                    <span class="colon">:&nbsp;</span>
                    <a class="argument-type" href="#graphql-type-Boolean">Boolean<span class="exclamation-mark">!</span></a>
                    <span class="equals">&nbsp;=&nbsp;</span><span class="argument-value">        <span class="false">false</span></span>
                    </div></div><span class="bracket-round">)</span></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__EnumValue" title=""><span class="bracket-square">[</span>__EnumValue<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-inputFields">inputFields</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__InputValue" title=""><span class="bracket-square">[</span>__InputValue<span class="exclamation-mark">!</span><span class="bracket-square">]</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-ofType">ofType</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__Type" title="">__Type</a>
                    
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
                        <span class="keyword" id="graphql-type-__Directive" title="Built-in introspection type.">type&nbsp;</span>
                        <span class="typename">__Directive</span>
                        <span class="implements"></span>
                        <span class="usage"></span>
                        <span class="bracket-curly">&nbsp;{</span>
                    </div>
                    <div class="line">
                        <div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-name">name</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-description">description</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-String" title="">String</a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-locations">locations</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__DirectiveLocation" title=""><span class="bracket-square">[</span>__DirectiveLocation<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-args">args</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-__InputValue" title=""><span class="bracket-square">[</span>__InputValue<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a>
                    
                </div></div><div class="item"><div class="line offset-1">
                    <span class="fieldname" id="graphql-type-isRepeatable">isRepeatable</span>
                    <div class="arguments"></div>
                    <span class="colon">:&nbsp;</span>
                    <a class="fieldtype" href="#graphql-type-Boolean" title="">Boolean<span class="exclamation-mark">!</span></a>
                    
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
                        <span class="keyword" title="">schema&nbsp;</span>
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <span class="fieldname">query</span>
                        <span class="colon">:&nbsp;</span>
                        <a class="fieldtype" href="#graphql-type-Query">Query</a>
                    </div>
                    <div class="line offset-1">
                        <span class="fieldname">mutation</span><span class="colon">:&nbsp;</span><span class="null">null</span>
                    </div>
                    <div class="line offset-1">
                        <span class="fieldname">subscription</span><span class="colon">:&nbsp;</span><span class="null">null</span>
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
                        <span class="keyword" title="Schema description">schema&nbsp;</span>
                        <span class="bracket-curly">{</span>
                    </div>
                    <div class="line offset-1">
                        <span class="fieldname">query</span>
                        <span class="colon">:&nbsp;</span>
                        <a class="fieldtype" href="#graphql-type-Query">Query</a>
                    </div>
                    <div class="line offset-1">
                        <span class="fieldname">mutation</span><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-Query">Query</a>
                    </div>
                    <div class="line offset-1">
                        <span class="fieldname">subscription</span><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-Query">Query</a>
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
        <section><div class="line"><span class="keyword" title="">schema&nbsp;</span><span class="bracket-curly">{</span></div><div class="line offset-1"><span class="fieldname">query</span><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-Query">Query</a></div><div class="line offset-1"><span class="fieldname">mutation</span><span class="colon">:&nbsp;</span><span class="null">null</span></div><div class="line offset-1"><span class="fieldname">subscription</span><span class="colon">:&nbsp;</span><span class="null">null</span></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-ChildInterface" title="">interface&nbsp;</span><span class="typename">ChildInterface</span><span class="implements">&nbsp;implements&nbsp;<a class="typename" href="#graphql-type-ParentInterface">ParentInterface</a></span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-name">name</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a></div></div><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-number">number</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-Int" title="">Int<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-ChildType" title="">type&nbsp;</span><span class="typename">ChildType</span><span class="implements">&nbsp;implements&nbsp;<a class="typename" href="#graphql-type-ChildInterface">ChildInterface</a> & <a class="typename" href="#graphql-type-SecondInterface">SecondInterface</a></span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-name">name</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a></div></div><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-number">number</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-Int" title="">Int<span class="exclamation-mark">!</span></a></div></div><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-secondField">secondField</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-ComplexDefaultsInput" title="ComplexDefaultsInput description">input&nbsp;</span><span class="typename">ComplexDefaultsInput</span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line offset-1"><div class="item"><span class="argument-name">name</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-String">String</a><span class="equals">&nbsp;=&nbsp;</span><span class="argument-value"><span class="">"default"</span></span></div><div class="item"><span class="argument-name">inner</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-ComplexDefaultsInput">ComplexDefaultsInput</a><span class="equals">&nbsp;=&nbsp;</span><span class="argument-value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span></span></div><div class="item"><span class="argument-name">innerList</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-ComplexDefaultsInput"><span class="bracket-square">[</span>ComplexDefaultsInput<span class="bracket-square">]</span></a><span class="equals">&nbsp;=&nbsp;</span><span class="argument-value"><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerList1"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerList2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="value"><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"string2"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="bracket-curly">{</span><span class="value"><span class="value-name">name</span><span class="colon">:</span><span class="">"innerInnerDefault"</span><span class="comma">,</span><span class="value-name">inner</span><span class="colon">:</span><span class="null">null</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="bracket-square">[</span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-curly">}</span><span class="comma">,</span><span class="value-name">innerList</span><span class="colon">:</span><span class="null">null</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span><span class="bracket-curly">}</span></span><span class="bracket-square">]</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-DescriptionEnum" title="">enum&nbsp;</span><span class="typename">DescriptionEnum</span><span class="bracket-curly">&nbsp;{</span></div><div class="line offset-1"><div class="item"><span class="enumitem line" title="single line description">A</span></div><div class="item"><span class="enumitem line" title="">B<span class="typename">&nbsp;@deprecated</span></span></div><div class="item"><span class="enumitem line" title="multi line
        description">C</span></div><div class="item"><span class="enumitem line" title="single line description">D<span class="typename">&nbsp;@deprecated</span><span class="bracket-round">(</span><span class="directive-usage-name">reason</span><span class="colon">:&nbsp;</span><span class="directive-usage-value">"reason"</span><span class="bracket-round">)</span></span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-ParentInterface" title="ParentInterface Description">interface&nbsp;</span><span class="typename">ParentInterface</span><span class="implements"></span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-name">name</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-Query" title="">type&nbsp;</span><span class="typename">Query</span><span class="implements"></span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-field1">field1</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String</a></div></div><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-fieldWithDescription">fieldWithDescription</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="Description to field">String</a></div></div><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-field2">field2</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String</a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SecondInterface" title="">interface&nbsp;</span><span class="typename">SecondInterface</span><span class="implements"></span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-secondField">secondField</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleEnum" title="">enum&nbsp;</span><span class="typename">SimpleEnum</span><span class="bracket-curly">&nbsp;{</span></div><div class="line offset-1"><div class="item"><span class="enumitem line" title="">A</span></div><div class="item"><span class="enumitem line" title="">B</span></div><div class="item"><span class="enumitem line" title="">C</span></div><div class="item"><span class="enumitem line" title="">D</span></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleInput" title="">input&nbsp;</span><span class="typename">SimpleInput</span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line offset-1"><div class="item"><span class="argument-name">name</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-String">String<span class="exclamation-mark">!</span></a></div><div class="item"><span class="argument-name">number</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-Int"><span class="bracket-square">[</span>Int<span class="exclamation-mark">!</span><span class="bracket-square">]</span><span class="exclamation-mark">!</span></a></div><div class="item"><span class="argument-name">bool</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-Boolean">Boolean</a></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleScalar" title="">scalar&nbsp;</span><span class="typename">SimpleScalar</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleType" title="Description for SimpleType">type&nbsp;</span><span class="typename">SimpleType</span><span class="implements"></span><span class="usage"></span><span class="bracket-curly">&nbsp;{</span></div><div class="line"><div class="item"><div class="line offset-1"><span class="fieldname" id="graphql-type-name">name</span><div class="arguments"></div><span class="colon">:&nbsp;</span><a class="fieldtype" href="#graphql-type-String" title="">String<span class="exclamation-mark">!</span></a></div></div></div><div class="line"><span class="bracket-curly">}</span></div></section><section><div class="line"><span class="keyword" id="graphql-type-SimpleUnion" title="">union&nbsp;</span><span class="typename">SimpleUnion = <a class="typename" href="#graphql-type-SimpleType">SimpleType</a> | <a class="typename" href="#graphql-type-ChildType">ChildType</a></span></div></section><section><div class="line"><span class="keyword" id="graphql-type-simpleDirective" title="">directive&nbsp;</span><span class="typename">@simpleDirective</span><span class="bracket-round">(</span><div class="line offset-1"><div class="item"><span class="argument-name">reason</span><span class="colon">:&nbsp;</span><a class="argument-type" href="#graphql-type-String">String</a></div></div><span class="bracket-round">)</span><span class="keyword">&nbsp;repeatable</span><span class="keyword">&nbsp;on&nbsp;</span><span class="location">FIELD | INLINE_FRAGMENT | FRAGMENT_SPREAD</span></div></section>
        EOL;

        $printer = new \Graphpinator\Printer\Printer(
            new \Graphpinator\Printer\HtmlVisitor(),
        );

        self::assertSame($expected, $printer->printSchema(TestSchema::getSchema()));
    }

    public function testValidateCorrectOrder() : void
    {
        $expected = [
            'interface&nbsp;</span><span class="typename">ChildInterface</span>',
            'interface&nbsp;</span><span class="typename">ParentInterface</span>',
            'interface&nbsp;</span><span class="typename">SecondInterface</span>',
            'type&nbsp;</span><span class="typename">ChildType</span>',
            'type&nbsp;</span><span class="typename">SimpleType</span>',
            'union&nbsp;</span><span class="typename">SimpleUnion',
            'input&nbsp;</span><span class="typename">ComplexDefaultsInput</span>',
            'input&nbsp;</span><span class="typename">SimpleInput</span>',
            'enum&nbsp;</span><span class="typename">DescriptionEnum</span>',
            'enum&nbsp;</span><span class="typename">SimpleEnum</span>',
            'directive&nbsp;</span><span class="typename">@simpleDirective</span>',
        ];

        $printer = new \Graphpinator\Printer\Printer(
            new \Graphpinator\Printer\HtmlVisitor(),
            new \Graphpinator\Printer\TypeKindSorter(),
        );
        $schema = $printer->printSchema(TestSchema::getSchema());
        $lastCheckedPos = 0;

        foreach ($expected as $type) {
            var_dump($type);
            $pos = \strpos($schema, $type);
            self::assertGreaterThan($lastCheckedPos, $pos);
            $lastCheckedPos = $pos;
        }
    }
}
