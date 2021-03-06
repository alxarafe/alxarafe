
window.projectVersion = 'master';

(function (root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Alxarafe" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe.html">Alxarafe</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Core" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core.html">Core</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Core_Autoload" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Autoload.html">Autoload</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Autoload_Load" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Autoload/Load.html">Load</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Base" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Base.html">Base</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Base_AuthController" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/AuthController.html">AuthController</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_AuthPageController" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/AuthPageController.html">AuthPageController</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_AuthPageExtendedController" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/AuthPageExtendedController.html">AuthPageExtendedController</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_Cache" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/Cache.html">Cache</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_CacheCore" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/CacheCore.html">CacheCore</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_Controller" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/Controller.html">Controller</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_Entity" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/Entity.html">Entity</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_FlatTable" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/FlatTable.html">FlatTable</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_SimpleTable" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/SimpleTable.html">SimpleTable</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Base_Table" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Base/Table.html">Table</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Controllers" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Controllers.html">Controllers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Controllers_CreateConfig" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/CreateConfig.html">CreateConfig</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_EditConfig" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/EditConfig.html">EditConfig</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Languages" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Languages.html">Languages</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Login" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Login.html">Login</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Modules" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Modules.html">Modules</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Pages" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Pages.html">Pages</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Roles" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Roles.html">Roles</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_RolesPages" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/RolesPages.html">RolesPages</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Tables" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Tables.html">Tables</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_Users" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/Users.html">Users</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Controllers_UsersRoles" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Controllers/UsersRoles.html">UsersRoles</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Database" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Database.html">Database</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Core_Database_Engines" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Database/Engines.html">Engines</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Database_Engines_PdoFirebird" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Database/Engines/PdoFirebird.html">PdoFirebird</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Database_Engines_PdoMySql" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Database/Engines/PdoMySql.html">PdoMySql</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Database_SqlHelpers" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Database/SqlHelpers.html">SqlHelpers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Database_SqlHelpers_SqlFirebird" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html">SqlFirebird</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Database_SqlHelpers_SqlMySql" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Database/SqlHelpers/SqlMySql.html">SqlMySql</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Alxarafe_Core_Database_Engine" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Database/Engine.html">Engine</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Database_SqlHelper" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Database/SqlHelper.html">SqlHelper</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_DebugBarCollectors" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/DebugBarCollectors.html">DebugBarCollectors</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_DebugBarCollectors_PhpCollector" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/DebugBarCollectors/PhpCollector.html">PhpCollector</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_DebugBarCollectors_TranslatorCollector" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html">TranslatorCollector</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Helpers" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Helpers.html">Helpers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Core_Helpers_Utils" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Helpers/Utils.html">Utils</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Helpers_Utils_ArrayUtils" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/Utils/ArrayUtils.html">ArrayUtils</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_Utils_ClassUtils" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/Utils/ClassUtils.html">ClassUtils</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_Utils_FileSystemUtils" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/Utils/FileSystemUtils.html">FileSystemUtils</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_Utils_TextUtils" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/Utils/TextUtils.html">TextUtils</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_FormatUtils" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/FormatUtils.html">FormatUtils</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_Schema" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/Schema.html">Schema</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_SchemaDB" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/SchemaDB.html">SchemaDB</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_Session" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/Session.html">Session</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_TwigFilters" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/TwigFilters.html">TwigFilters</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Helpers_TwigFunctions" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Helpers/TwigFunctions.html">TwigFunctions</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Models" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Models.html">Models</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Models_Language" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/Language.html">Language</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_Module" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/Module.html">Module</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_Page" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/Page.html">Page</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_Role" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/Role.html">Role</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_RolePage" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/RolePage.html">RolePage</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_TableModel" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/TableModel.html">TableModel</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_User" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/User.html">User</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Models_UserRole" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Models/UserRole.html">UserRole</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_PreProcessors" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/PreProcessors.html">PreProcessors</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_PreProcessors_Languages" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/PreProcessors/Languages.html">Languages</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_PreProcessors_Models" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/PreProcessors/Models.html">Models</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_PreProcessors_Pages" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/PreProcessors/Pages.html">Pages</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_PreProcessors_Routes" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/PreProcessors/Routes.html">Routes</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Providers" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Providers.html">Providers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Providers_Config" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Config.html">Config</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_Container" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Container.html">Container</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_Database" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Database.html">Database</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_DebugTool" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/DebugTool.html">DebugTool</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_FlashMessages" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/FlashMessages.html">FlashMessages</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_Logger" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Logger.html">Logger</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_ModuleManager" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/ModuleManager.html">ModuleManager</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_RegionalInfo" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/RegionalInfo.html">RegionalInfo</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_Router" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Router.html">Router</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_Singleton" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Singleton.html">Singleton</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_TemplateRender" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/TemplateRender.html">TemplateRender</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Providers_Translator" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Providers/Translator.html">Translator</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Renders" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Renders.html">Renders</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Core_Renders_Twig" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Renders/Twig.html">Twig</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Core_Renders_Twig_Components" >                    <div style="padding-left:72px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Renders/Twig/Components.html">Components</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Renders_Twig_Components_AbstractComponent" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html">AbstractComponent</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Renders_Twig_Components_Alert" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Core/Renders/Twig/Components/Alert.html">Alert</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Renders_Twig_Components_Button" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Core/Renders/Twig/Components/Button.html">Button</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Core_Traits" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Core/Traits.html">Traits</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Core_Traits_AjaxDataTableTrait" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Traits/AjaxDataTableTrait.html">AjaxDataTableTrait</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_Traits_MagicTrait" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Core/Traits/MagicTrait.html">MagicTrait</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Alxarafe_Core_BootStrap" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Core/BootStrap.html">BootStrap</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Core_InitializerAbstract" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Core/InitializerAbstract.html">InitializerAbstract</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Test" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test.html">Test</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Test_Core" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core.html">Core</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Test_Core_Autoload" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core/Autoload.html">Autoload</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Test_Core_Autoload_LoadTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Autoload/LoadTest.html">LoadTest</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Test_Core_Base" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core/Base.html">Base</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Test_Core_Base_AuthControllerTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Base/AuthControllerTest.html">AuthControllerTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Base_AuthPageControllerTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Base/AuthPageControllerTest.html">AuthPageControllerTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Base_AuthPageExtendedControllerTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html">AuthPageExtendedControllerTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Base_CacheCoreTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Base/CacheCoreTest.html">CacheCoreTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Base_ControllerTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Base/ControllerTest.html">ControllerTest</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Test_Core_Controllers" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core/Controllers.html">Controllers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Test_Core_Controllers_CreateConfigTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/CreateConfigTest.html">CreateConfigTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_EditConfigTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/EditConfigTest.html">EditConfigTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_LanguagesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/LanguagesTest.html">LanguagesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_LoginTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/LoginTest.html">LoginTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_ModulesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/ModulesTest.html">ModulesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_PagesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/PagesTest.html">PagesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_RolesPagesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/RolesPagesTest.html">RolesPagesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_RolesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/RolesTest.html">RolesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_TablesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/TablesTest.html">TablesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_UsersRolesTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/UsersRolesTest.html">UsersRolesTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Controllers_UsersTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Controllers/UsersTest.html">UsersTest</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Test_Core_Helpers" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core/Helpers.html">Helpers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Test_Core_Helpers_Utils" >                    <div style="padding-left:72px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core/Helpers/Utils.html">Utils</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Test_Core_Helpers_Utils_ArrayUtilsTest" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html">ArrayUtilsTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Helpers_Utils_ClassUtilsTest" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html">ClassUtilsTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Helpers_Utils_FileSystemUtilsTest" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html">FileSystemUtilsTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Helpers_Utils_TextUtilsTest" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html">TextUtilsTest</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Helpers_FormatUtilsTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Helpers/FormatUtilsTest.html">FormatUtilsTest</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Test_Core_Models" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Test/Core/Models.html">Models</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Test_Core_Models_LanguageTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/LanguageTest.html">LanguageTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_ModuleTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/ModuleTest.html">ModuleTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_PageTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/PageTest.html">PageTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_RolePageTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/RolePageTest.html">RolePageTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_RoleTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/RoleTest.html">RoleTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_TableModelTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/TableModelTest.html">TableModelTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_UserRoleTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/UserRoleTest.html">UserRoleTest</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Test_Core_Models_UserTest" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Alxarafe/Test/Core/Models/UserTest.html">UserTest</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Modules" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Modules.html">Modules</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Modules_Sample" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Modules/Sample.html">Sample</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Modules_Sample_Controllers" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Modules/Sample/Controllers.html">Controllers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Modules_Sample_Controllers_Countries" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Controllers/Countries.html">Countries</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Controllers_IntermediateRegions" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Controllers/IntermediateRegions.html">IntermediateRegions</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Controllers_People" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Controllers/People.html">People</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Controllers_Regions" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Controllers/Regions.html">Regions</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Controllers_Subregions" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Controllers/Subregions.html">Subregions</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Modules_Sample_Models" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Modules/Sample/Models.html">Models</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Modules_Sample_Models_Country" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Models/Country.html">Country</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Models_IntermediateRegion" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Models/IntermediateRegion.html">IntermediateRegion</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Models_Person" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Models/Person.html">Person</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Models_Region" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Models/Region.html">Region</a>                    </div>                </li>                            <li data-name="class:Modules_Sample_Models_Subregion" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Modules/Sample/Models/Subregion.html">Subregion</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [

        {
            "type": "Namespace",
            "link": "Alxarafe.html",
            "name": "Alxarafe",
            "doc": "Namespace Alxarafe"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core.html",
            "name": "Alxarafe\\Core",
            "doc": "Namespace Alxarafe\\Core"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Autoload.html",
            "name": "Alxarafe\\Core\\Autoload",
            "doc": "Namespace Alxarafe\\Core\\Autoload"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Base.html",
            "name": "Alxarafe\\Core\\Base",
            "doc": "Namespace Alxarafe\\Core\\Base"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Controllers.html",
            "name": "Alxarafe\\Core\\Controllers",
            "doc": "Namespace Alxarafe\\Core\\Controllers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Database.html",
            "name": "Alxarafe\\Core\\Database",
            "doc": "Namespace Alxarafe\\Core\\Database"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Database/Engines.html",
            "name": "Alxarafe\\Core\\Database\\Engines",
            "doc": "Namespace Alxarafe\\Core\\Database\\Engines"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Database/SqlHelpers.html",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers",
            "doc": "Namespace Alxarafe\\Core\\Database\\SqlHelpers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/DebugBarCollectors.html",
            "name": "Alxarafe\\Core\\DebugBarCollectors",
            "doc": "Namespace Alxarafe\\Core\\DebugBarCollectors"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Helpers.html",
            "name": "Alxarafe\\Core\\Helpers",
            "doc": "Namespace Alxarafe\\Core\\Helpers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Helpers/Utils.html",
            "name": "Alxarafe\\Core\\Helpers\\Utils",
            "doc": "Namespace Alxarafe\\Core\\Helpers\\Utils"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Models.html",
            "name": "Alxarafe\\Core\\Models",
            "doc": "Namespace Alxarafe\\Core\\Models"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/PreProcessors.html",
            "name": "Alxarafe\\Core\\PreProcessors",
            "doc": "Namespace Alxarafe\\Core\\PreProcessors"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Providers.html",
            "name": "Alxarafe\\Core\\Providers",
            "doc": "Namespace Alxarafe\\Core\\Providers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Renders.html",
            "name": "Alxarafe\\Core\\Renders",
            "doc": "Namespace Alxarafe\\Core\\Renders"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Renders/Twig.html",
            "name": "Alxarafe\\Core\\Renders\\Twig",
            "doc": "Namespace Alxarafe\\Core\\Renders\\Twig"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Renders/Twig/Components.html",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components",
            "doc": "Namespace Alxarafe\\Core\\Renders\\Twig\\Components"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Core/Traits.html",
            "name": "Alxarafe\\Core\\Traits",
            "doc": "Namespace Alxarafe\\Core\\Traits"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test.html",
            "name": "Alxarafe\\Test",
            "doc": "Namespace Alxarafe\\Test"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core.html",
            "name": "Alxarafe\\Test\\Core",
            "doc": "Namespace Alxarafe\\Test\\Core"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core/Autoload.html",
            "name": "Alxarafe\\Test\\Core\\Autoload",
            "doc": "Namespace Alxarafe\\Test\\Core\\Autoload"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core/Base.html",
            "name": "Alxarafe\\Test\\Core\\Base",
            "doc": "Namespace Alxarafe\\Test\\Core\\Base"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core/Controllers.html",
            "name": "Alxarafe\\Test\\Core\\Controllers",
            "doc": "Namespace Alxarafe\\Test\\Core\\Controllers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core/Helpers.html",
            "name": "Alxarafe\\Test\\Core\\Helpers",
            "doc": "Namespace Alxarafe\\Test\\Core\\Helpers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core/Helpers/Utils.html",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils",
            "doc": "Namespace Alxarafe\\Test\\Core\\Helpers\\Utils"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Test/Core/Models.html",
            "name": "Alxarafe\\Test\\Core\\Models",
            "doc": "Namespace Alxarafe\\Test\\Core\\Models"
        }, {
            "type": "Namespace",
            "link": "Modules.html",
            "name": "Modules",
            "doc": "Namespace Modules"
        }, {
            "type": "Namespace",
            "link": "Modules/Sample.html",
            "name": "Modules\\Sample",
            "doc": "Namespace Modules\\Sample"
        }, {
            "type": "Namespace",
            "link": "Modules/Sample/Controllers.html",
            "name": "Modules\\Sample\\Controllers",
            "doc": "Namespace Modules\\Sample\\Controllers"
        }, {
            "type": "Namespace",
            "link": "Modules/Sample/Models.html",
            "name": "Modules\\Sample\\Models",
            "doc": "Namespace Modules\\Sample\\Models"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Autoload",
            "fromLink": "Alxarafe/Core/Autoload.html",
            "link": "Alxarafe/Core/Autoload/Load.html",
            "name": "Alxarafe\\Core\\Autoload\\Load",
            "doc": "&quot;Class Load&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Autoload\\Load",
            "fromLink": "Alxarafe/Core/Autoload/Load.html",
            "link": "Alxarafe/Core/Autoload/Load.html#method___construct",
            "name": "Alxarafe\\Core\\Autoload\\Load::__construct",
            "doc": "&quot;Load constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Autoload\\Load",
            "fromLink": "Alxarafe/Core/Autoload/Load.html",
            "link": "Alxarafe/Core/Autoload/Load.html#method_init",
            "name": "Alxarafe\\Core\\Autoload\\Load::init",
            "doc": "&quot;Adds a directory to the list of supported directories.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Autoload\\Load",
            "fromLink": "Alxarafe/Core/Autoload/Load.html",
            "link": "Alxarafe/Core/Autoload/Load.html#method_addDirs",
            "name": "Alxarafe\\Core\\Autoload\\Load::addDirs",
            "doc": "&quot;Add more directories to our list of directories to test.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Autoload\\Load",
            "fromLink": "Alxarafe/Core/Autoload/Load.html",
            "link": "Alxarafe/Core/Autoload/Load.html#method_getInstance",
            "name": "Alxarafe\\Core\\Autoload\\Load::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Autoload\\Load",
            "fromLink": "Alxarafe/Core/Autoload/Load.html",
            "link": "Alxarafe/Core/Autoload/Load.html#method_autoLoad",
            "name": "Alxarafe\\Core\\Autoload\\Load::autoLoad",
            "doc": "&quot;Performs the logic to locate the file based on the namespaced classname. This method derives a filename by\nconverting the PHP namespace separator \\ into the directory separator appropriate for this server and appending\nthe extension .php.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Autoload\\Load",
            "fromLink": "Alxarafe/Core/Autoload/Load.html",
            "link": "Alxarafe/Core/Autoload/Load.html#method_loadFile",
            "name": "Alxarafe\\Core\\Autoload\\Load::loadFile",
            "doc": "&quot;Load a file if exists.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/AuthController.html",
            "name": "Alxarafe\\Core\\Base\\AuthController",
            "doc": "&quot;Class AuthController&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthController",
            "fromLink": "Alxarafe/Core/Base/AuthController.html",
            "link": "Alxarafe/Core/Base/AuthController.html#method_runMethod",
            "name": "Alxarafe\\Core\\Base\\AuthController::runMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthController",
            "fromLink": "Alxarafe/Core/Base/AuthController.html",
            "link": "Alxarafe/Core/Base/AuthController.html#method_checkAuth",
            "name": "Alxarafe\\Core\\Base\\AuthController::checkAuth",
            "doc": "&quot;Check that user is logged in.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthController",
            "fromLink": "Alxarafe/Core/Base/AuthController.html",
            "link": "Alxarafe/Core/Base/AuthController.html#method_checkLoginWeb",
            "name": "Alxarafe\\Core\\Base\\AuthController::checkLoginWeb",
            "doc": "&quot;Check if user is logged-in from Login.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthController",
            "fromLink": "Alxarafe/Core/Base/AuthController.html",
            "link": "Alxarafe/Core/Base/AuthController.html#method_checkLoginAPI",
            "name": "Alxarafe\\Core\\Base\\AuthController::checkLoginAPI",
            "doc": "&quot;Check if user is logged-in from API.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthController",
            "fromLink": "Alxarafe/Core/Base/AuthController.html",
            "link": "Alxarafe/Core/Base/AuthController.html#method_adjustCookieUser",
            "name": "Alxarafe\\Core\\Base\\AuthController::adjustCookieUser",
            "doc": "&quot;Adjust auth cookie user.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthController",
            "fromLink": "Alxarafe/Core/Base/AuthController.html",
            "link": "Alxarafe/Core/Base/AuthController.html#method_logout",
            "name": "Alxarafe\\Core\\Base\\AuthController::logout",
            "doc": "&quot;Close the user session and go to the main page&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html",
            "name": "Alxarafe\\Core\\Base\\AuthPageController",
            "doc": "&quot;Class AuthPageController, all controllers that needs to be accessed as a page must extends from this.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::__construct",
            "doc": "&quot;AuthPageController constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_setPageDetails",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::setPageDetails",
            "doc": "&quot;Set the page details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::indexMethod",
            "doc": "&quot;Start point and default list of registers.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_createMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::createMethod",
            "doc": "&quot;Default create method for new registers.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_readMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::readMethod",
            "doc": "&quot;Default show method for show an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_updateMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::updateMethod",
            "doc": "&quot;Default update method for update an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_deleteMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::deleteMethod",
            "doc": "&quot;Default delete method for delete an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_runMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::runMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_loadPerms",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::loadPerms",
            "doc": "&quot;Load perms for this user.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_canAction",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::canAction",
            "doc": "&quot;Verify if this user can do an action.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_getUserMenu",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::getUserMenu",
            "doc": "&quot;Return a list of pages for generate user menu.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageController",
            "fromLink": "Alxarafe/Core/Base/AuthPageController.html",
            "link": "Alxarafe/Core/Base/AuthPageController.html#method_getPageDetails",
            "name": "Alxarafe\\Core\\Base\\AuthPageController::getPageDetails",
            "doc": "&quot;Returns the page details as array.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "doc": "&quot;Class AuthPageExtendedController&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::__construct",
            "doc": "&quot;AuthPageExtendedController constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_getExtraActions",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::getExtraActions",
            "doc": "&quot;Returns a list of extra actions.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_getStatus",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::getStatus",
            "doc": "&quot;Returns the actual status of the controller.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_addMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::addMethod",
            "doc": "&quot;Create new record, used as alias&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_createMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::createMethod",
            "doc": "&quot;Create new record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_initialize",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::initialize",
            "doc": "&quot;Initialize common properties&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_getRecordData",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::getRecordData",
            "doc": "&quot;Obtains an array of data from register $this-&gt;currentId.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_showMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::showMethod",
            "doc": "&quot;Read existing record, used as alias&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_readMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::readMethod",
            "doc": "&quot;Read existing record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_editMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::editMethod",
            "doc": "&quot;Update existing record, used as alias&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_updateMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::updateMethod",
            "doc": "&quot;Update existing record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_cancel",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::cancel",
            "doc": "&quot;Cancels goes to main controller status.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_save",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::save",
            "doc": "&quot;Save the data.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_getDataPost",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::getDataPost",
            "doc": "&quot;Returns the data received from $_POST&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_removeMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::removeMethod",
            "doc": "&quot;Default delete method for delete an individual register, used as alias&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_deleteMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::deleteMethod",
            "doc": "&quot;Default delete method for delete an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_accessDenied",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::accessDenied",
            "doc": "&quot;Access denied page.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::indexMethod",
            "doc": "&quot;The start point of the controller.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_listData",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::listData",
            "doc": "&quot;List all records on model.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_getActionButtons",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::getActionButtons",
            "doc": "&quot;Returns a list of actions buttons. By default returns Read\/Update\/Delete actions.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\AuthPageExtendedController",
            "fromLink": "Alxarafe/Core/Base/AuthPageExtendedController.html",
            "link": "Alxarafe/Core/Base/AuthPageExtendedController.html#method_setDefaults",
            "name": "Alxarafe\\Core\\Base\\AuthPageExtendedController::setDefaults",
            "doc": "&quot;Se le pasa un registro con datos de la tabla actual, y cumplimenta los que\nfalten con los datos por defecto.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/Cache.html",
            "name": "Alxarafe\\Core\\Base\\Cache",
            "doc": "&quot;Class Cache. This class is fully supported with Symfony Cache.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Cache",
            "fromLink": "Alxarafe/Core/Base/Cache.html",
            "link": "Alxarafe/Core/Base/Cache.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\Cache::__construct",
            "doc": "&quot;Cache constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Cache",
            "fromLink": "Alxarafe/Core/Base/Cache.html",
            "link": "Alxarafe/Core/Base/Cache.html#method_connectMemcache",
            "name": "Alxarafe\\Core\\Base\\Cache::connectMemcache",
            "doc": "&quot;Sets Memcache engine. Requires ext-memcached&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Cache",
            "fromLink": "Alxarafe/Core/Base/Cache.html",
            "link": "Alxarafe/Core/Base/Cache.html#method_connectPDO",
            "name": "Alxarafe\\Core\\Base\\Cache::connectPDO",
            "doc": "&quot;Sets PDO engine.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Cache",
            "fromLink": "Alxarafe/Core/Base/Cache.html",
            "link": "Alxarafe/Core/Base/Cache.html#method_connectPhpFiles",
            "name": "Alxarafe\\Core\\Base\\Cache::connectPhpFiles",
            "doc": "&quot;Sets PHP Files engine.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Cache",
            "fromLink": "Alxarafe/Core/Base/Cache.html",
            "link": "Alxarafe/Core/Base/Cache.html#method_connectFilesystem",
            "name": "Alxarafe\\Core\\Base\\Cache::connectFilesystem",
            "doc": "&quot;Sets Filesystem engine.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/CacheCore.html",
            "name": "Alxarafe\\Core\\Base\\CacheCore",
            "doc": "&quot;Class CacheCore. This class is fully supported with Symfony Cache.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\CacheCore",
            "fromLink": "Alxarafe/Core/Base/CacheCore.html",
            "link": "Alxarafe/Core/Base/CacheCore.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\CacheCore::__construct",
            "doc": "&quot;CacheCore constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\CacheCore",
            "fromLink": "Alxarafe/Core/Base/CacheCore.html",
            "link": "Alxarafe/Core/Base/CacheCore.html#method_connectPhpArray",
            "name": "Alxarafe\\Core\\Base\\CacheCore::connectPhpArray",
            "doc": "&quot;Sets PhpArray engine.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\CacheCore",
            "fromLink": "Alxarafe/Core/Base/CacheCore.html",
            "link": "Alxarafe/Core/Base/CacheCore.html#method_getInstance",
            "name": "Alxarafe\\Core\\Base\\CacheCore::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\CacheCore",
            "fromLink": "Alxarafe/Core/Base/CacheCore.html",
            "link": "Alxarafe/Core/Base/CacheCore.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Base\\CacheCore::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\CacheCore",
            "fromLink": "Alxarafe/Core/Base/CacheCore.html",
            "link": "Alxarafe/Core/Base/CacheCore.html#method_getEngine",
            "name": "Alxarafe\\Core\\Base\\CacheCore::getEngine",
            "doc": "&quot;Give access to the cache engine.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/Controller.html",
            "name": "Alxarafe\\Core\\Base\\Controller",
            "doc": "&quot;Class Controller&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\Controller::__construct",
            "doc": "&quot;Controller constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_sendResponseTemplate",
            "name": "Alxarafe\\Core\\Base\\Controller::sendResponseTemplate",
            "doc": "&quot;Add new vars to render, render the template and send the Response.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_sendResponse",
            "name": "Alxarafe\\Core\\Base\\Controller::sendResponse",
            "doc": "&quot;Send the Response with data received.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_redirect",
            "name": "Alxarafe\\Core\\Base\\Controller::redirect",
            "doc": "&quot;Send a RedirectResponse to destiny receive.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_runMethod",
            "name": "Alxarafe\\Core\\Base\\Controller::runMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_addToVar",
            "name": "Alxarafe\\Core\\Base\\Controller::addToVar",
            "doc": "&quot;Add a new element to a value saved in the array that is passed to the template.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_addResource",
            "name": "Alxarafe\\Core\\Base\\Controller::addResource",
            "doc": "&quot;Check if the resource is in the application&#039;s resource folder (for example, in the css or js folders\nof the skin folder). It&#039;s a specific file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_addCSS",
            "name": "Alxarafe\\Core\\Base\\Controller::addCSS",
            "doc": "&quot;addCSS includes the CSS files to template.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_addJS",
            "name": "Alxarafe\\Core\\Base\\Controller::addJS",
            "doc": "&quot;addJS includes the JS files to template.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_getArrayPost",
            "name": "Alxarafe\\Core\\Base\\Controller::getArrayPost",
            "doc": "&quot;Return body parameters $_POST values.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_getArrayGet",
            "name": "Alxarafe\\Core\\Base\\Controller::getArrayGet",
            "doc": "&quot;Return query string parameters $_GET values.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_getArrayServer",
            "name": "Alxarafe\\Core\\Base\\Controller::getArrayServer",
            "doc": "&quot;Return server and execution environment parameters from $_SERVER values.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_getArrayHeaders",
            "name": "Alxarafe\\Core\\Base\\Controller::getArrayHeaders",
            "doc": "&quot;Return headers from $_SERVER header values.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_getArrayFiles",
            "name": "Alxarafe\\Core\\Base\\Controller::getArrayFiles",
            "doc": "&quot;Return uploaded files from $_FILES.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Controller",
            "fromLink": "Alxarafe/Core/Base/Controller.html",
            "link": "Alxarafe/Core/Base/Controller.html#method_getArrayCookies",
            "name": "Alxarafe\\Core\\Base\\Controller::getArrayCookies",
            "doc": "&quot;Return cookies from $_COOKIES.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/Entity.html",
            "name": "Alxarafe\\Core\\Base\\Entity",
            "doc": "&quot;Class Entity&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\Entity::__construct",
            "doc": "&quot;Entity constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_getId",
            "name": "Alxarafe\\Core\\Base\\Entity::getId",
            "doc": "&quot;Return the value of id.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_getNameField",
            "name": "Alxarafe\\Core\\Base\\Entity::getNameField",
            "doc": "&quot;Returns the name of the identification field of the record. By default it will be name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_setData",
            "name": "Alxarafe\\Core\\Base\\Entity::setData",
            "doc": "&quot;Assign newData from $data.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_getIdField",
            "name": "Alxarafe\\Core\\Base\\Entity::getIdField",
            "doc": "&quot;Returns the name of the main key field of the table (PK-Primary Key). By\ndefault it will be id.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_getData",
            "name": "Alxarafe\\Core\\Base\\Entity::getData",
            "doc": "&quot;Return newData details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_getOldData",
            "name": "Alxarafe\\Core\\Base\\Entity::getOldData",
            "doc": "&quot;Return oldData details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method_setOldData",
            "name": "Alxarafe\\Core\\Base\\Entity::setOldData",
            "doc": "&quot;Assign oldData from an array.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method___call",
            "name": "Alxarafe\\Core\\Base\\Entity::__call",
            "doc": "&quot;Execute a magic method of the setField or getField style&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method___get",
            "name": "Alxarafe\\Core\\Base\\Entity::__get",
            "doc": "&quot;Magic getter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method___set",
            "name": "Alxarafe\\Core\\Base\\Entity::__set",
            "doc": "&quot;Magic setter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Entity",
            "fromLink": "Alxarafe/Core/Base/Entity.html",
            "link": "Alxarafe/Core/Base/Entity.html#method___isset",
            "name": "Alxarafe\\Core\\Base\\Entity::__isset",
            "doc": "&quot;Magic isset.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/FlatTable.html",
            "name": "Alxarafe\\Core\\Base\\FlatTable",
            "doc": "&quot;Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its\nstructure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\FlatTable::__construct",
            "doc": "&quot;Build a Table model. $table is the name of the table in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_get",
            "name": "Alxarafe\\Core\\Base\\FlatTable::get",
            "doc": "&quot;Returns a new instance of the table with the requested record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_getDataById",
            "name": "Alxarafe\\Core\\Base\\FlatTable::getDataById",
            "doc": "&quot;This method is private. Use load instead.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_getQuotedTableName",
            "name": "Alxarafe\\Core\\Base\\FlatTable::getQuotedTableName",
            "doc": "&quot;Get the name of the table (with prefix)&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_newRecord",
            "name": "Alxarafe\\Core\\Base\\FlatTable::newRecord",
            "doc": "&quot;Sets the active record in a new record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_defaultData",
            "name": "Alxarafe\\Core\\Base\\FlatTable::defaultData",
            "doc": "&quot;TODO: Undocummented.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_getTableName",
            "name": "Alxarafe\\Core\\Base\\FlatTable::getTableName",
            "doc": "&quot;Get the name of the table (with prefix)&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_getDataArray",
            "name": "Alxarafe\\Core\\Base\\FlatTable::getDataArray",
            "doc": "&quot;Return an array with the current active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_load",
            "name": "Alxarafe\\Core\\Base\\FlatTable::load",
            "doc": "&quot;Establishes a record as an active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_save",
            "name": "Alxarafe\\Core\\Base\\FlatTable::save",
            "doc": "&quot;Saves the changes made to the active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_updateRecord",
            "name": "Alxarafe\\Core\\Base\\FlatTable::updateRecord",
            "doc": "&quot;Update the modified fields in the active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_insertRecord",
            "name": "Alxarafe\\Core\\Base\\FlatTable::insertRecord",
            "doc": "&quot;Insert a new record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\FlatTable",
            "fromLink": "Alxarafe/Core/Base/FlatTable.html",
            "link": "Alxarafe/Core/Base/FlatTable.html#method_delete",
            "name": "Alxarafe\\Core\\Base\\FlatTable::delete",
            "doc": "&quot;Deletes the active record.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html",
            "name": "Alxarafe\\Core\\Base\\SimpleTable",
            "doc": "&quot;Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its\nstructure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::__construct",
            "doc": "&quot;Build a Table model. $table is the name of the table in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_setStructure",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::setStructure",
            "doc": "&quot;Execute a call to setTableStructure with an array containing 3 arrays with the fields, keys and default values\nfor the table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_setTableStructure",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::setTableStructure",
            "doc": "&quot;Save the structure of the table in a static array, so that it is available at all times.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getStructureArray",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getStructureArray",
            "doc": "&quot;A raw array is built with all the information available in the table, configuration files and code.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getFieldsFromTable",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getFieldsFromTable",
            "doc": "&quot;Return a list of fields and their table structure. Each final model that needed, must overwrite it.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_defaultData",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::defaultData",
            "doc": "&quot;TODO: Undocummented.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getBy",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getBy",
            "doc": "&quot;Returns a new instance of the table with the requested record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getDataBy",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getDataBy",
            "doc": "&quot;This method is private. Use getBy instead.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getStructure",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getStructure",
            "doc": "&quot;Returns the structure of the normalized table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getAllRecords",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getAllRecords",
            "doc": "&quot;Get an array with all data in table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_countAllRecords",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::countAllRecords",
            "doc": "&quot;Count all registers in table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_getAllRecordsPaged",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::getAllRecordsPaged",
            "doc": "&quot;Get an array with all data per page.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_search",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::search",
            "doc": "&quot;Do a search to a table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_searchQuery",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::searchQuery",
            "doc": "&quot;Return the main part of the search SQL query.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Core/Base/SimpleTable.html",
            "link": "Alxarafe/Core/Base/SimpleTable.html#method_searchCount",
            "name": "Alxarafe\\Core\\Base\\SimpleTable::searchCount",
            "doc": "&quot;Do a search to a table.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Base",
            "fromLink": "Alxarafe/Core/Base.html",
            "link": "Alxarafe/Core/Base/Table.html",
            "name": "Alxarafe\\Core\\Base\\Table",
            "doc": "&quot;Class Table allows access to a table using an active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method___construct",
            "name": "Alxarafe\\Core\\Base\\Table::__construct",
            "doc": "&quot;Build a Table model. $table is the name of the table in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_checkStructure",
            "name": "Alxarafe\\Core\\Base\\Table::checkStructure",
            "doc": "&quot;Create a new table if it does not exist and it has been passed true as a parameter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_getIdByName",
            "name": "Alxarafe\\Core\\Base\\Table::getIdByName",
            "doc": "&quot;Perform a search of a record by the name, returning the id of the corresponding record, or &#039;&#039; if it is not found\nor does not have a name field.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_getAllRecordsBy",
            "name": "Alxarafe\\Core\\Base\\Table::getAllRecordsBy",
            "doc": "&quot;Get an array with all data.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_getIndexesFromTable",
            "name": "Alxarafe\\Core\\Base\\Table::getIndexesFromTable",
            "doc": "&quot;Return a list of key indexes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Base\\Table::getDefaultValues",
            "doc": "&quot;Return a list of default values.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_getDefaultValue",
            "name": "Alxarafe\\Core\\Base\\Table::getDefaultValue",
            "doc": "&quot;Get default value data for this valueData.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_getChecksFromTable",
            "name": "Alxarafe\\Core\\Base\\Table::getChecksFromTable",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_saveRecord",
            "name": "Alxarafe\\Core\\Base\\Table::saveRecord",
            "doc": "&quot;Save the data to a record if pass the test and returns true\/false based on the result.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_testData",
            "name": "Alxarafe\\Core\\Base\\Table::testData",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Base\\Table",
            "fromLink": "Alxarafe/Core/Base/Table.html",
            "link": "Alxarafe/Core/Base/Table.html#method_saveData",
            "name": "Alxarafe\\Core\\Base\\Table::saveData",
            "doc": "&quot;Try to save the data and return true\/false based on the result.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core",
            "fromLink": "Alxarafe/Core.html",
            "link": "Alxarafe/Core/BootStrap.html",
            "name": "Alxarafe\\Core\\BootStrap",
            "doc": "&quot;Class BootStrap&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\BootStrap",
            "fromLink": "Alxarafe/Core/BootStrap.html",
            "link": "Alxarafe/Core/BootStrap.html#method___construct",
            "name": "Alxarafe\\Core\\BootStrap::__construct",
            "doc": "&quot;BootStrap constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\BootStrap",
            "fromLink": "Alxarafe/Core/BootStrap.html",
            "link": "Alxarafe/Core/BootStrap.html#method_getInstance",
            "name": "Alxarafe\\Core\\BootStrap::getInstance",
            "doc": "&quot;Returns this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\BootStrap",
            "fromLink": "Alxarafe/Core/BootStrap.html",
            "link": "Alxarafe/Core/BootStrap.html#method_getStartTime",
            "name": "Alxarafe\\Core\\BootStrap::getStartTime",
            "doc": "&quot;Return start time with microtime.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\BootStrap",
            "fromLink": "Alxarafe/Core/BootStrap.html",
            "link": "Alxarafe/Core/BootStrap.html#method_init",
            "name": "Alxarafe\\Core\\BootStrap::init",
            "doc": "&quot;Initialize the class.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\BootStrap",
            "fromLink": "Alxarafe/Core/BootStrap.html",
            "link": "Alxarafe/Core/BootStrap.html#method_toContainer",
            "name": "Alxarafe\\Core\\BootStrap::toContainer",
            "doc": "&quot;Put it to a container, to be accessible from any place.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\BootStrap",
            "fromLink": "Alxarafe/Core/BootStrap.html",
            "link": "Alxarafe/Core/BootStrap.html#method_run",
            "name": "Alxarafe\\Core\\BootStrap::run",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "doc": "&quot;Controller for editing database and skin settings.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "fromLink": "Alxarafe/Core/Controllers/CreateConfig.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig::indexMethod",
            "doc": "&quot;The start point of the controller.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "fromLink": "Alxarafe/Core/Controllers/CreateConfig.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html#method_setDefaultData",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig::setDefaultData",
            "doc": "&quot;Sets default data values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "fromLink": "Alxarafe/Core/Controllers/CreateConfig.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html#method_save",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig::save",
            "doc": "&quot;Save the form changes in the configuration file&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "fromLink": "Alxarafe/Core/Controllers/CreateConfig.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html#method_generateMethod",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig::generateMethod",
            "doc": "&quot;Regenerate some needed data.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "fromLink": "Alxarafe/Core/Controllers/CreateConfig.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig::pageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\CreateConfig",
            "fromLink": "Alxarafe/Core/Controllers/CreateConfig.html",
            "link": "Alxarafe/Core/Controllers/CreateConfig.html#method_getTimezoneList",
            "name": "Alxarafe\\Core\\Controllers\\CreateConfig::getTimezoneList",
            "doc": "&quot;Returns a list of timezones list with GMT offset&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig",
            "doc": "&quot;Controller for editing database and skin settings.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_getTimezoneList",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::getTimezoneList",
            "doc": "&quot;Returns a list of timezones list with GMT offset&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_createMethod",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::createMethod",
            "doc": "&quot;Default create method for new registers.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::indexMethod",
            "doc": "&quot;The start point of the controller.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_setDefaultData",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::setDefaultData",
            "doc": "&quot;Sets default data values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_save",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::save",
            "doc": "&quot;Save the form changes in the configuration file&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_readMethod",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::readMethod",
            "doc": "&quot;Default read method for show an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_updateMethod",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::updateMethod",
            "doc": "&quot;Default update method for update an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Core/Controllers/EditConfig.html",
            "link": "Alxarafe/Core/Controllers/EditConfig.html#method_deleteMethod",
            "name": "Alxarafe\\Core\\Controllers\\EditConfig::deleteMethod",
            "doc": "&quot;Default delete method for delete an individual register.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Languages.html",
            "name": "Alxarafe\\Core\\Controllers\\Languages",
            "doc": "&quot;Class Languages&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Languages",
            "fromLink": "Alxarafe/Core/Controllers/Languages.html",
            "link": "Alxarafe/Core/Controllers/Languages.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\Languages::__construct",
            "doc": "&quot;Languages constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Languages",
            "fromLink": "Alxarafe/Core/Controllers/Languages.html",
            "link": "Alxarafe/Core/Controllers/Languages.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Controllers\\Languages::indexMethod",
            "doc": "&quot;Main is invoked if method is not specified. Check if you have to save changes or just exit.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Languages",
            "fromLink": "Alxarafe/Core/Controllers/Languages.html",
            "link": "Alxarafe/Core/Controllers/Languages.html#method_exportAction",
            "name": "Alxarafe\\Core\\Controllers\\Languages::exportAction",
            "doc": "&quot;Export language files with all strings for each language.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Languages",
            "fromLink": "Alxarafe/Core/Controllers/Languages.html",
            "link": "Alxarafe/Core/Controllers/Languages.html#method_getExtraActions",
            "name": "Alxarafe\\Core\\Controllers\\Languages::getExtraActions",
            "doc": "&quot;Returns a list of extra actions.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Languages",
            "fromLink": "Alxarafe/Core/Controllers/Languages.html",
            "link": "Alxarafe/Core/Controllers/Languages.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Languages::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Login.html",
            "name": "Alxarafe\\Core\\Controllers\\Login",
            "doc": "&quot;Class Login&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Login::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Controllers\\Login::indexMethod",
            "doc": "&quot;The start point of the controller.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_redirectToController",
            "name": "Alxarafe\\Core\\Controllers\\Login::redirectToController",
            "doc": "&quot;Redirect to controller, default or selected by the user.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_getCookieUser",
            "name": "Alxarafe\\Core\\Controllers\\Login::getCookieUser",
            "doc": "&quot;Returns the cookie from the user&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_adjustCookieUser",
            "name": "Alxarafe\\Core\\Controllers\\Login::adjustCookieUser",
            "doc": "&quot;Adjust auth cookie user.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_clearCookieUser",
            "name": "Alxarafe\\Core\\Controllers\\Login::clearCookieUser",
            "doc": "&quot;Clear the cookie user.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_main",
            "name": "Alxarafe\\Core\\Controllers\\Login::main",
            "doc": "&quot;Main is invoked if method is not specified.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_logoutMethod",
            "name": "Alxarafe\\Core\\Controllers\\Login::logoutMethod",
            "doc": "&quot;Close the user session and go to the main page&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_getUserName",
            "name": "Alxarafe\\Core\\Controllers\\Login::getUserName",
            "doc": "&quot;Returns the user name if setted or null.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_getUser",
            "name": "Alxarafe\\Core\\Controllers\\Login::getUser",
            "doc": "&quot;Returns the user if setted or null.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Login",
            "fromLink": "Alxarafe/Core/Controllers/Login.html",
            "link": "Alxarafe/Core/Controllers/Login.html#method_setUser",
            "name": "Alxarafe\\Core\\Controllers\\Login::setUser",
            "doc": "&quot;Set cookie&#039;s user.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Modules.html",
            "name": "Alxarafe\\Core\\Controllers\\Modules",
            "doc": "&quot;Class Modules&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\Modules::__construct",
            "doc": "&quot;Modules constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_indexMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::indexMethod",
            "doc": "&quot;The start point of the controller.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_getAvailableModules",
            "name": "Alxarafe\\Core\\Controllers\\Modules::getAvailableModules",
            "doc": "&quot;Returns a list of availabe modules.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_updateModulesData",
            "name": "Alxarafe\\Core\\Controllers\\Modules::updateModulesData",
            "doc": "&quot;Updated all modules to database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_createMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::createMethod",
            "doc": "&quot;Default create method for new registers.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_readMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::readMethod",
            "doc": "&quot;Default read method for new registers.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_updateMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::updateMethod",
            "doc": "&quot;Default update method for update an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_deleteMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::deleteMethod",
            "doc": "&quot;Default delete method for delete an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_enableMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::enableMethod",
            "doc": "&quot;Default enable method for enable an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_disableMethod",
            "name": "Alxarafe\\Core\\Controllers\\Modules::disableMethod",
            "doc": "&quot;Default disable method for disable an individual register.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Modules::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Modules",
            "fromLink": "Alxarafe/Core/Controllers/Modules.html",
            "link": "Alxarafe/Core/Controllers/Modules.html#method_getActionButtons",
            "name": "Alxarafe\\Core\\Controllers\\Modules::getActionButtons",
            "doc": "&quot;Returns a list of actions buttons. By default returns Read\/Update\/Delete actions.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Pages.html",
            "name": "Alxarafe\\Core\\Controllers\\Pages",
            "doc": "&quot;Class Pages&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Pages",
            "fromLink": "Alxarafe/Core/Controllers/Pages.html",
            "link": "Alxarafe/Core/Controllers/Pages.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\Pages::__construct",
            "doc": "&quot;Pages constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Pages",
            "fromLink": "Alxarafe/Core/Controllers/Pages.html",
            "link": "Alxarafe/Core/Controllers/Pages.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Pages::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Roles.html",
            "name": "Alxarafe\\Core\\Controllers\\Roles",
            "doc": "&quot;Class Roles&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Roles",
            "fromLink": "Alxarafe/Core/Controllers/Roles.html",
            "link": "Alxarafe/Core/Controllers/Roles.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\Roles::__construct",
            "doc": "&quot;Roles constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Roles",
            "fromLink": "Alxarafe/Core/Controllers/Roles.html",
            "link": "Alxarafe/Core/Controllers/Roles.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Roles::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/RolesPages.html",
            "name": "Alxarafe\\Core\\Controllers\\RolesPages",
            "doc": "&quot;Class RolesPages&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\RolesPages",
            "fromLink": "Alxarafe/Core/Controllers/RolesPages.html",
            "link": "Alxarafe/Core/Controllers/RolesPages.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\RolesPages::__construct",
            "doc": "&quot;RolesPages constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\RolesPages",
            "fromLink": "Alxarafe/Core/Controllers/RolesPages.html",
            "link": "Alxarafe/Core/Controllers/RolesPages.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\RolesPages::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Tables.html",
            "name": "Alxarafe\\Core\\Controllers\\Tables",
            "doc": "&quot;Class Models&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Tables",
            "fromLink": "Alxarafe/Core/Controllers/Tables.html",
            "link": "Alxarafe/Core/Controllers/Tables.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\Tables::__construct",
            "doc": "&quot;Tables constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Tables",
            "fromLink": "Alxarafe/Core/Controllers/Tables.html",
            "link": "Alxarafe/Core/Controllers/Tables.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Tables::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/Users.html",
            "name": "Alxarafe\\Core\\Controllers\\Users",
            "doc": "&quot;Class Users&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Users",
            "fromLink": "Alxarafe/Core/Controllers/Users.html",
            "link": "Alxarafe/Core/Controllers/Users.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\Users::__construct",
            "doc": "&quot;Users constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\Users",
            "fromLink": "Alxarafe/Core/Controllers/Users.html",
            "link": "Alxarafe/Core/Controllers/Users.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\Users::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Controllers",
            "fromLink": "Alxarafe/Core/Controllers.html",
            "link": "Alxarafe/Core/Controllers/UsersRoles.html",
            "name": "Alxarafe\\Core\\Controllers\\UsersRoles",
            "doc": "&quot;Class UsersRoles&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\UsersRoles",
            "fromLink": "Alxarafe/Core/Controllers/UsersRoles.html",
            "link": "Alxarafe/Core/Controllers/UsersRoles.html#method___construct",
            "name": "Alxarafe\\Core\\Controllers\\UsersRoles::__construct",
            "doc": "&quot;UsersRoles constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Controllers\\UsersRoles",
            "fromLink": "Alxarafe/Core/Controllers/UsersRoles.html",
            "link": "Alxarafe/Core/Controllers/UsersRoles.html#method_pageDetails",
            "name": "Alxarafe\\Core\\Controllers\\UsersRoles::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Database",
            "fromLink": "Alxarafe/Core/Database.html",
            "link": "Alxarafe/Core/Database/Engine.html",
            "name": "Alxarafe\\Core\\Database\\Engine",
            "doc": "&quot;Engine provides generic support for databases.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method___construct",
            "name": "Alxarafe\\Core\\Database\\Engine::__construct",
            "doc": "&quot;Engine constructor&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_getEngines",
            "name": "Alxarafe\\Core\\Database\\Engine::getEngines",
            "doc": "&quot;Return a list of available database engines.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_unsupportedEngines",
            "name": "Alxarafe\\Core\\Database\\Engine::unsupportedEngines",
            "doc": "&quot;Returns a list of unsupported engines.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_getStructure",
            "name": "Alxarafe\\Core\\Database\\Engine::getStructure",
            "doc": "&quot;Obtain an array with the table structure with a standardized format.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_batchExec",
            "name": "Alxarafe\\Core\\Database\\Engine::batchExec",
            "doc": "&quot;Execute SQL statements on the database (INSERT, UPDATE or DELETE).&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_exec",
            "name": "Alxarafe\\Core\\Database\\Engine::exec",
            "doc": "&quot;Prepare and execute the query.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_selectCoreCache",
            "name": "Alxarafe\\Core\\Database\\Engine::selectCoreCache",
            "doc": "&quot;Executes a SELECT SQL statement on the core cache.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_select",
            "name": "Alxarafe\\Core\\Database\\Engine::select",
            "doc": "&quot;Executes a SELECT SQL statement on the database, returning the result in an array.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_clearCoreCache",
            "name": "Alxarafe\\Core\\Database\\Engine::clearCoreCache",
            "doc": "&quot;Clear item from cache.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method___destruct",
            "name": "Alxarafe\\Core\\Database\\Engine::__destruct",
            "doc": "&quot;Engine destructor&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_rollBackTransactions",
            "name": "Alxarafe\\Core\\Database\\Engine::rollBackTransactions",
            "doc": "&quot;Undo all active transactions&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_rollBack",
            "name": "Alxarafe\\Core\\Database\\Engine::rollBack",
            "doc": "&quot;Rollback current transaction,&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_getLastInserted",
            "name": "Alxarafe\\Core\\Database\\Engine::getLastInserted",
            "doc": "&quot;Returns the id of the last inserted record. Failing that, it returns &#039;&#039;.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_checkConnection",
            "name": "Alxarafe\\Core\\Database\\Engine::checkConnection",
            "doc": "&quot;Returns if a database connection exists or not.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_connect",
            "name": "Alxarafe\\Core\\Database\\Engine::connect",
            "doc": "&quot;Establish a connection to the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_prepare",
            "name": "Alxarafe\\Core\\Database\\Engine::prepare",
            "doc": "&quot;Prepares a statement for execution and returns a statement object&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_resultSet",
            "name": "Alxarafe\\Core\\Database\\Engine::resultSet",
            "doc": "&quot;Returns an array containing all of the result set rows&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_execute",
            "name": "Alxarafe\\Core\\Database\\Engine::execute",
            "doc": "&quot;Executes a prepared statement&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_beginTransaction",
            "name": "Alxarafe\\Core\\Database\\Engine::beginTransaction",
            "doc": "&quot;Start transaction&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_commit",
            "name": "Alxarafe\\Core\\Database\\Engine::commit",
            "doc": "&quot;Commit current transaction&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_getDbStructure",
            "name": "Alxarafe\\Core\\Database\\Engine::getDbStructure",
            "doc": "&quot;Returns database structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_getDbTableStructure",
            "name": "Alxarafe\\Core\\Database\\Engine::getDbTableStructure",
            "doc": "&quot;Returns database table structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_issetDbTableStructure",
            "name": "Alxarafe\\Core\\Database\\Engine::issetDbTableStructure",
            "doc": "&quot;Returns if table is set to database structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_issetDbTableStructureKey",
            "name": "Alxarafe\\Core\\Database\\Engine::issetDbTableStructureKey",
            "doc": "&quot;Returns if key is set to database structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engine",
            "fromLink": "Alxarafe/Core/Database/Engine.html",
            "link": "Alxarafe/Core/Database/Engine.html#method_setDbTableStructure",
            "name": "Alxarafe\\Core\\Database\\Engine::setDbTableStructure",
            "doc": "&quot;Sets database structure for a tablename.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Database\\Engines",
            "fromLink": "Alxarafe/Core/Database/Engines.html",
            "link": "Alxarafe/Core/Database/Engines/PdoFirebird.html",
            "name": "Alxarafe\\Core\\Database\\Engines\\PdoFirebird",
            "doc": "&quot;Personalization of PDO to use Firebird.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engines\\PdoFirebird",
            "fromLink": "Alxarafe/Core/Database/Engines/PdoFirebird.html",
            "link": "Alxarafe/Core/Database/Engines/PdoFirebird.html#method___construct",
            "name": "Alxarafe\\Core\\Database\\Engines\\PdoFirebird::__construct",
            "doc": "&quot;PdoMySql constructor. Add aditional parameters to self::$dsn string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engines\\PdoFirebird",
            "fromLink": "Alxarafe/Core/Database/Engines/PdoFirebird.html",
            "link": "Alxarafe/Core/Database/Engines/PdoFirebird.html#method_select",
            "name": "Alxarafe\\Core\\Database\\Engines\\PdoFirebird::select",
            "doc": "&quot;Executes a SELECT SQL statement on the database, returning the result in an array.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Database\\Engines",
            "fromLink": "Alxarafe/Core/Database/Engines.html",
            "link": "Alxarafe/Core/Database/Engines/PdoMySql.html",
            "name": "Alxarafe\\Core\\Database\\Engines\\PdoMySql",
            "doc": "&quot;Personalization of PDO to use MySQL.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engines\\PdoMySql",
            "fromLink": "Alxarafe/Core/Database/Engines/PdoMySql.html",
            "link": "Alxarafe/Core/Database/Engines/PdoMySql.html#method___construct",
            "name": "Alxarafe\\Core\\Database\\Engines\\PdoMySql::__construct",
            "doc": "&quot;PdoMySql constructor. Add aditional parameters to self::$dsn string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\Engines\\PdoMySql",
            "fromLink": "Alxarafe/Core/Database/Engines/PdoMySql.html",
            "link": "Alxarafe/Core/Database/Engines/PdoMySql.html#method_connect",
            "name": "Alxarafe\\Core\\Database\\Engines\\PdoMySql::connect",
            "doc": "&quot;Connect to the database.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Database",
            "fromLink": "Alxarafe/Core/Database.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html",
            "name": "Alxarafe\\Core\\Database\\SqlHelper",
            "doc": "&quot;Engine provides generic support for databases.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method___construct",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::__construct",
            "doc": "&quot;SqlHelper constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_quoteTableName",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::quoteTableName",
            "doc": "&quot;Returns the name of the table in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_quoteFieldName",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::quoteFieldName",
            "doc": "&quot;Returns the name of the field in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_quoteLiteral",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::quoteLiteral",
            "doc": "&quot;Returns the name of the field in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getTables",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getTables",
            "doc": "&quot;Returns an array with the name of all the tables in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getSqlTableExists",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getSqlTableExists",
            "doc": "&quot;Returns if table exists in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getSQLField",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getSQLField",
            "doc": "&quot;TODO: Undocummented.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getColumns",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getColumns",
            "doc": "&quot;Returns an array with all the columns of a table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getColumnsSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getColumnsSql",
            "doc": "&quot;SQL statement that returns the fields in the table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_normalizeFields",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::normalizeFields",
            "doc": "&quot;Modifies the structure returned by the query generated with getColumnsSql to the normalized format that returns\ngetColumns&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getIndexes",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getIndexes",
            "doc": "&quot;Obtains information about the indices of the table in a normalized array\nand independent of the database engine&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_getIndexesSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::getIndexesSql",
            "doc": "&quot;Obtain an array with the basic information about the indexes of the table, which will be supplemented with the\nrestrictions later.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Core/Database/SqlHelper.html",
            "link": "Alxarafe/Core/Database/SqlHelper.html#method_normalizeIndexes",
            "name": "Alxarafe\\Core\\Database\\SqlHelper::normalizeIndexes",
            "doc": "&quot;Returns an array with the index information, and if there are, also constraints.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "doc": "&quot;Personalization of SQL queries to use Firebird.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method___construct",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::__construct",
            "doc": "&quot;SqlFirebird constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_quoteLiteral",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::quoteLiteral",
            "doc": "&quot;Returns the name of the field in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getTables",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getTables",
            "doc": "&quot;Returns an array with the name of all the tables in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_quoteTableName",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::quoteTableName",
            "doc": "&quot;Returns the name of the table in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getColumnsSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getColumnsSql",
            "doc": "&quot;SQL statement that returns the fields in the table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_normalizeFields",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::normalizeFields",
            "doc": "&quot;Modifies the structure returned by the query generated with getColumnsSql to the normalized format that returns\ngetColumns&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_normalizeIndexes",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::normalizeIndexes",
            "doc": "&quot;uniqueConstraints:\n     TC_ARTICULOS_CODIGO_U:\n         columns:\n             - CODIGOARTICULO\nindexes:\n     FK_ARTICULO_PORCENTAJEIMPUESTO:\n         columns:\n             - IDPORCENTAJEIMPUESTO&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getIndexesSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getIndexesSql",
            "doc": "&quot;Obtain an array with the basic information about the indexes of the table, which will be supplemented with the\nrestrictions later.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_normalizeConstraints",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::normalizeConstraints",
            "doc": "&quot;&#039;TABLE_NAME&#039; =&gt; string &#039;clientes&#039; (length=8)\n&#039;COLUMN_NAME&#039; =&gt; string &#039;codgrupo&#039; (length=8)\n&#039;CONSTRAINT_NAME&#039; =&gt; string &#039;ca_clientes_grupos&#039; (length=18)\n&#039;REFERENCED_TABLE_NAME&#039; =&gt; string &#039;gruposclientes&#039; (length=14)\n&#039;REFERENCED_COLUMN_NAME&#039; =&gt; string &#039;codgrupo&#039; (length=8)&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getViewsSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getViewsSql",
            "doc": "&quot;Returns the views from the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getConstraintsSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getConstraintsSql",
            "doc": "&quot;TODO: Undocumented and pending complete.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getSQLField",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getSQLField",
            "doc": "&quot;TODO: Undocummented.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlFirebird.html#method_getSqlTableExists",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlFirebird::getSqlTableExists",
            "doc": "&quot;Returns if table exists in the database.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "doc": "&quot;Personalization of SQL queries to use MySQL.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method___construct",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::__construct",
            "doc": "&quot;SqlMySql constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getTables",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getTables",
            "doc": "&quot;Returns an array with the name of all the tables in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getColumnsSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getColumnsSql",
            "doc": "&quot;SQL statement that returns the fields in the table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getSQLField",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getSQLField",
            "doc": "&quot;TODO: Undocummented.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_toNative",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::toNative",
            "doc": "&quot;TODO: Undocumented and pending complete.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_toInteger",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::toInteger",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_toString",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::toString",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_normalizeFields",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::normalizeFields",
            "doc": "&quot;Modifies the structure returned by the query generated with getColumnsSql to the normalized format that returns\ngetColumns&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_splitType",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::splitType",
            "doc": "&quot;Divide the data type of a MySQL field into its various components: type, length, unsigned or zerofill, if\napplicable.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_normalizeIndexes",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::normalizeIndexes",
            "doc": "&quot;Returns an array with the index information, and if there are, also constraints.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getConstraintData",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getConstraintData",
            "doc": "&quot;The data about the constraint that is found in the KEY_COLUMN_USAGE table is returned.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getTablename",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getTablename",
            "doc": "&quot;Return the DataBaseName or an empty string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getConstraintRules",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getConstraintRules",
            "doc": "&quot;The rules for updating and deleting data with constraint (table REFERENTIAL_CONSTRAINTS) are returned.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getIndexesSql",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getIndexesSql",
            "doc": "&quot;Obtain an array with the basic information about the indexes of the table, which will be supplemented with the\nrestrictions later.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Core/Database/SqlHelpers/SqlMySql.html#method_getSqlTableExists",
            "name": "Alxarafe\\Core\\Database\\SqlHelpers\\SqlMySql::getSqlTableExists",
            "doc": "&quot;Returns if table exists in the database.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors",
            "fromLink": "Alxarafe/Core/DebugBarCollectors.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "doc": "&quot;This class collects all PHP errors, notice, advices, trigger_error, .&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method___construct",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::__construct",
            "doc": "&quot;PHPCollector constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method_collect",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::collect",
            "doc": "&quot;Called by the DebugBar when data needs to be collected.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method_getMessages",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::getMessages",
            "doc": "&quot;Returns a list of messages ordered by their timestamp.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method_getWidgets",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::getWidgets",
            "doc": "&quot;Returns a hash where keys are control names and their values an array of options as defined in\n{see DebugBar\\JavascriptRenderer::addControl()}&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method_getName",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::getName",
            "doc": "&quot;Returns the unique name of the collector.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method_errorHandler",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::errorHandler",
            "doc": "&quot;Exception error handler. Called from constructor with set_error_handler to add all details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/PhpCollector.html#method_friendlyErrorType",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\PhpCollector::friendlyErrorType",
            "doc": "&quot;Return error name from error code.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors",
            "fromLink": "Alxarafe/Core/DebugBarCollectors.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "doc": "&quot;This class collects the translations&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html#method___construct",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector::__construct",
            "doc": "&quot;TranslationCollector constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html#method_getName",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector::getName",
            "doc": "&quot;Returns the unique name of the collector&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html#method_getWidgets",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector::getWidgets",
            "doc": "&quot;Returns a hash where keys are control names and their values\nan array of options as defined in {see DebugBar\\JavascriptRenderer::addControl()}&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html#method_getAssets",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector::getAssets",
            "doc": "&quot;Returns the needed assets&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html#method_collect",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector::collect",
            "doc": "&quot;Called by the DebugBar when data needs to be collected&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector",
            "fromLink": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html",
            "link": "Alxarafe/Core/DebugBarCollectors/TranslatorCollector.html#method_addTranslations",
            "name": "Alxarafe\\Core\\DebugBarCollectors\\TranslatorCollector::addTranslations",
            "doc": "&quot;Add a translation key to the collector&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers",
            "fromLink": "Alxarafe/Core/Helpers.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "doc": "&quot;Class FormatUtils, this class simplifies the way to get the final format for date, time and datetime.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormatDate",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormatDate",
            "doc": "&quot;Returns the format for date.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_loadConfig",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::loadConfig",
            "doc": "&quot;Load config.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormatDateTime",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormatDateTime",
            "doc": "&quot;Returns the format for date time.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormatTime",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormatTime",
            "doc": "&quot;Returns the format for time.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormattedDate",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormattedDate",
            "doc": "&quot;Return date formatted.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormatted",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormatted",
            "doc": "&quot;Return formatted string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormattedTime",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormattedTime",
            "doc": "&quot;Return date formatted.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\FormatUtils",
            "fromLink": "Alxarafe/Core/Helpers/FormatUtils.html",
            "link": "Alxarafe/Core/Helpers/FormatUtils.html#method_getFormattedDateTime",
            "name": "Alxarafe\\Core\\Helpers\\FormatUtils::getFormattedDateTime",
            "doc": "&quot;Return date formatted.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers",
            "fromLink": "Alxarafe/Core/Helpers.html",
            "link": "Alxarafe/Core/Helpers/Schema.html",
            "name": "Alxarafe\\Core\\Helpers\\Schema",
            "doc": "&quot;The Schema class contains static methods that allow you to manipulate the\ndatabase. It is used to create and modify tables and indexes in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method___construct",
            "name": "Alxarafe\\Core\\Helpers\\Schema::__construct",
            "doc": "&quot;Schema constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_saveStructure",
            "name": "Alxarafe\\Core\\Helpers\\Schema::saveStructure",
            "doc": "&quot;It collects the information from the database and creates files in YAML format\nfor the reconstruction of its structure. Also save the view structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_saveTableStructure",
            "name": "Alxarafe\\Core\\Helpers\\Schema::saveTableStructure",
            "doc": "&quot;Return true if complete table structure was saved, otherwise return false.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_mergeArray",
            "name": "Alxarafe\\Core\\Helpers\\Schema::mergeArray",
            "doc": "&quot;Merge the existing yaml file with the structure of the database,\nprevailing the latter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_mergeViewData",
            "name": "Alxarafe\\Core\\Helpers\\Schema::mergeViewData",
            "doc": "&quot;Verify the parameters established in the yaml file with the structure of the database, creating the missing data\nand correcting the possible errors.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_mergeViewField",
            "name": "Alxarafe\\Core\\Helpers\\Schema::mergeViewField",
            "doc": "&quot;Verify the $fieldData established in the yaml file with the structure of\nthe database, creating the missing data and correcting the possible errors.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_getFromYamlFile",
            "name": "Alxarafe\\Core\\Helpers\\Schema::getFromYamlFile",
            "doc": "&quot;Returns an array with data from the specified yaml file&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_getSchemaFileName",
            "name": "Alxarafe\\Core\\Helpers\\Schema::getSchemaFileName",
            "doc": "&quot;Returns the path to the specified file, or empty string if it does not exist.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_loadDataFromCsv",
            "name": "Alxarafe\\Core\\Helpers\\Schema::loadDataFromCsv",
            "doc": "&quot;Load data from CSV file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_loadDataFromYaml",
            "name": "Alxarafe\\Core\\Helpers\\Schema::loadDataFromYaml",
            "doc": "&quot;Load data from Yaml file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_saveSchemaFileName",
            "name": "Alxarafe\\Core\\Helpers\\Schema::saveSchemaFileName",
            "doc": "&quot;Save the data array in a .yaml file&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_setNormalizedStructure",
            "name": "Alxarafe\\Core\\Helpers\\Schema::setNormalizedStructure",
            "doc": "&quot;Normalize an array that has the file structure defined in the model by setStructure, so that it has fields with\nall the values it must have. Those that do not exist are created with the default value, avoiding having to do\nthe check each time, or calculating their value based on the data provided by the other fields.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_normalizeField",
            "name": "Alxarafe\\Core\\Helpers\\Schema::normalizeField",
            "doc": "&quot;Take the definition of a field, and make sure you have all the information that is necessary for its creation or\nmaintenance, calculating the missing data if possible. It can cause an exception if some vital data is missing,\nbut this should only occur at the design stage.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Schema",
            "fromLink": "Alxarafe/Core/Helpers/Schema.html",
            "link": "Alxarafe/Core/Helpers/Schema.html#method_setValues",
            "name": "Alxarafe\\Core\\Helpers\\Schema::setValues",
            "doc": "&quot;Create the SQL statements to fill the table with default data.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers",
            "fromLink": "Alxarafe/Core/Helpers.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "doc": "&quot;The SchemaDB class contains static methods that allow you to manipulate the database. It is used to create and\nmodify tables and indexes in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_getTables",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::getTables",
            "doc": "&quot;Return the tables on the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_checkTableStructure",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::checkTableStructure",
            "doc": "&quot;Create or update the structure of the table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_tableExists",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::tableExists",
            "doc": "&quot;Return true if $tableName exists in database&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_updateFields",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::updateFields",
            "doc": "&quot;Update fields for tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_modifyFields",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::modifyFields",
            "doc": "&quot;Modify (add or change) fields for tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_assignFields",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::assignFields",
            "doc": "&quot;Convert an array of fields into a string to be added to an SQL command, CREATE TABLE or ALTER TABLE.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_quoteTableName",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::quoteTableName",
            "doc": "&quot;Returns the name of the table in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createFields",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createFields",
            "doc": "&quot;Build the SQL statement to create the fields in the table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createIndex",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createIndex",
            "doc": "&quot;Create the SQL statements for the construction of one index.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createPrimaryIndex",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createPrimaryIndex",
            "doc": "&quot;Creates index for primary key of tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_quoteFieldName",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::quoteFieldName",
            "doc": "&quot;Returns the name of the field in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createConstraint",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createConstraint",
            "doc": "&quot;Creates a constraint for tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createStandardIndex",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createStandardIndex",
            "doc": "&quot;Creates a standard index for tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createUniqueIndex",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createUniqueIndex",
            "doc": "&quot;Creates a unique index for the tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\SchemaDB",
            "fromLink": "Alxarafe/Core/Helpers/SchemaDB.html",
            "link": "Alxarafe/Core/Helpers/SchemaDB.html#method_createTableView",
            "name": "Alxarafe\\Core\\Helpers\\SchemaDB::createTableView",
            "doc": "&quot;Create a tableView&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers",
            "fromLink": "Alxarafe/Core/Helpers.html",
            "link": "Alxarafe/Core/Helpers/Session.html",
            "name": "Alxarafe\\Core\\Helpers\\Session",
            "doc": "&quot;Class Session.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method___construct",
            "name": "Alxarafe\\Core\\Helpers\\Session::__construct",
            "doc": "&quot;Session constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getInstance",
            "name": "Alxarafe\\Core\\Helpers\\Session::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Helpers\\Session::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getCsrfToken",
            "name": "Alxarafe\\Core\\Helpers\\Session::getCsrfToken",
            "doc": "&quot;Gets the value of the outgoing CSRF token.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_isValid",
            "name": "Alxarafe\\Core\\Helpers\\Session::isValid",
            "doc": "&quot;Checks whether an incoming CSRF token value is valid.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getSession",
            "name": "Alxarafe\\Core\\Helpers\\Session::getSession",
            "doc": "&quot;Return this session.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_setSegment",
            "name": "Alxarafe\\Core\\Helpers\\Session::setSegment",
            "doc": "&quot;Sets segment name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_get",
            "name": "Alxarafe\\Core\\Helpers\\Session::get",
            "doc": "&quot;Get data from segment.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getSegment",
            "name": "Alxarafe\\Core\\Helpers\\Session::getSegment",
            "doc": "&quot;Return segment session.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_set",
            "name": "Alxarafe\\Core\\Helpers\\Session::set",
            "doc": "&quot;Set data key.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_setFlash",
            "name": "Alxarafe\\Core\\Helpers\\Session::setFlash",
            "doc": "&quot;Sets flash next data by key.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_setFlashNext",
            "name": "Alxarafe\\Core\\Helpers\\Session::setFlashNext",
            "doc": "&quot;Sets flash next data by key.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getFlash",
            "name": "Alxarafe\\Core\\Helpers\\Session::getFlash",
            "doc": "&quot;Get flash now data by key.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getFlashNow",
            "name": "Alxarafe\\Core\\Helpers\\Session::getFlashNow",
            "doc": "&quot;Get flash now data by key.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_setFlashNow",
            "name": "Alxarafe\\Core\\Helpers\\Session::setFlashNow",
            "doc": "&quot;Sets flash now data by key.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Session",
            "fromLink": "Alxarafe/Core/Helpers/Session.html",
            "link": "Alxarafe/Core/Helpers/Session.html#method_getFlashNext",
            "name": "Alxarafe\\Core\\Helpers\\Session::getFlashNext",
            "doc": "&quot;Get flash next data by key.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers",
            "fromLink": "Alxarafe/Core/Helpers.html",
            "link": "Alxarafe/Core/Helpers/TwigFilters.html",
            "name": "Alxarafe\\Core\\Helpers\\TwigFilters",
            "doc": "&quot;Class TwigFilters.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFilters",
            "fromLink": "Alxarafe/Core/Helpers/TwigFilters.html",
            "link": "Alxarafe/Core/Helpers/TwigFilters.html#method_getFilters",
            "name": "Alxarafe\\Core\\Helpers\\TwigFilters::getFilters",
            "doc": "&quot;Return a list of filters.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFilters",
            "fromLink": "Alxarafe/Core/Helpers/TwigFilters.html",
            "link": "Alxarafe/Core/Helpers/TwigFilters.html#method_test",
            "name": "Alxarafe\\Core\\Helpers\\TwigFilters::test",
            "doc": "&quot;A sample filter.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers",
            "fromLink": "Alxarafe/Core/Helpers.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "doc": "&quot;Class TwigFunctions&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method___construct",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::__construct",
            "doc": "&quot;TwigFunctions constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_getFunctions",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::getFunctions",
            "doc": "&quot;Return a list of functions.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_flash",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::flash",
            "doc": "&quot;Returns data messages from flash information.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_copyright",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::copyright",
            "doc": "&quot;Returns the copyright content.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_getTotalTime",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::getTotalTime",
            "doc": "&quot;Returns the total execution time.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_unescape",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::unescape",
            "doc": "&quot;Unescape html entities.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_snakeToCamel",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::snakeToCamel",
            "doc": "&quot;Returns the string to camel case format.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_trans",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::trans",
            "doc": "&quot;Returns a translated string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_getResourceUri",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::getResourceUri",
            "doc": "&quot;Check different possible locations for the file and return the\ncorresponding URI, if it exists.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_getHeader",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::getHeader",
            "doc": "&quot;Returns the necessary html code in the header of the template, to display the debug bar.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_getFooter",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::getFooter",
            "doc": "&quot;Returns the necessary html code at the footer of the template, to display the debug bar.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_renderComponent",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::renderComponent",
            "doc": "&quot;Renders the component with shared data.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\TwigFunctions",
            "fromLink": "Alxarafe/Core/Helpers/TwigFunctions.html",
            "link": "Alxarafe/Core/Helpers/TwigFunctions.html#method_getUrl",
            "name": "Alxarafe\\Core\\Helpers\\TwigFunctions::getUrl",
            "doc": "&quot;Returns the base url.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Core/Helpers/Utils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils",
            "doc": "&quot;Class ArrayUtils&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html#method_flatArray",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils::flatArray",
            "doc": "&quot;Flatten an array to leave it at a single level.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html#method_addToArray",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils::addToArray",
            "doc": "&quot;Add the elements of the 2nd array behind those of the first.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html#method_isTrue",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils::isTrue",
            "doc": "&quot;Return true if $param is setted and is &#039;yes&#039;, otherwise return false.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html#method_getItem",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils::getItem",
            "doc": "&quot;Given an array of parameters, an index and a possible default value,\nreturns a literal of the form: index = &#039;value&#039;.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ArrayUtils.html#method_arrayMergeRecursiveEx",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ArrayUtils::arrayMergeRecursiveEx",
            "doc": "&quot;Array recursive merge excluding duplicate values.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Core/Helpers/Utils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ClassUtils.html",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ClassUtils",
            "doc": "&quot;Class ClassUtils&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ClassUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ClassUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ClassUtils.html#method_defineIfNotExists",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ClassUtils::defineIfNotExists",
            "doc": "&quot;Define a constant if it does not exist&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\ClassUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/ClassUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/ClassUtils.html#method_getShortName",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\ClassUtils::getShortName",
            "doc": "&quot;Returns the short name of the class.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Core/Helpers/Utils.html",
            "link": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils",
            "doc": "&quot;Class FileSystemUtils&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html#method_rrmdir",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils::rrmdir",
            "doc": "&quot;Recursively removes a folder along with all its files and directories&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html#method_mkdir",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils::mkdir",
            "doc": "&quot;Attempts to create the directory specified by pathname.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html#method_scandir",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils::scandir",
            "doc": "&quot;List files and directories inside the specified path.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/FileSystemUtils.html#method_locate",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\FileSystemUtils::locate",
            "doc": "&quot;Locate a file in a subfolder, returning the FQCN or filepath.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Core/Helpers/Utils.html",
            "link": "Alxarafe/Core/Helpers/Utils/TextUtils.html",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils",
            "doc": "&quot;Class TextUtils&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/TextUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/TextUtils.html#method_camelToSnake",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils::camelToSnake",
            "doc": "&quot;Translate a literal in CamelCase format to snake_case format&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/TextUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/TextUtils.html#method_snakeToCamel",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils::snakeToCamel",
            "doc": "&quot;Translate a literal in snake_case format to CamelCase format&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils",
            "fromLink": "Alxarafe/Core/Helpers/Utils/TextUtils.html",
            "link": "Alxarafe/Core/Helpers/Utils/TextUtils.html#method_randomString",
            "name": "Alxarafe\\Core\\Helpers\\Utils\\TextUtils::randomString",
            "doc": "&quot;Generate a random string for a given length.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core",
            "fromLink": "Alxarafe/Core.html",
            "link": "Alxarafe/Core/InitializerAbstract.html",
            "name": "Alxarafe\\Core\\InitializerAbstract",
            "doc": "&quot;Class InitializerAbstract&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\InitializerAbstract",
            "fromLink": "Alxarafe/Core/InitializerAbstract.html",
            "link": "Alxarafe/Core/InitializerAbstract.html#method_init",
            "name": "Alxarafe\\Core\\InitializerAbstract::init",
            "doc": "&quot;Code to load on every exection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\InitializerAbstract",
            "fromLink": "Alxarafe/Core/InitializerAbstract.html",
            "link": "Alxarafe/Core/InitializerAbstract.html#method_install",
            "name": "Alxarafe\\Core\\InitializerAbstract::install",
            "doc": "&quot;Code to load when module is installed.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\InitializerAbstract",
            "fromLink": "Alxarafe/Core/InitializerAbstract.html",
            "link": "Alxarafe/Core/InitializerAbstract.html#method_update",
            "name": "Alxarafe\\Core\\InitializerAbstract::update",
            "doc": "&quot;Code to load  when module is updated.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\InitializerAbstract",
            "fromLink": "Alxarafe/Core/InitializerAbstract.html",
            "link": "Alxarafe/Core/InitializerAbstract.html#method_enabled",
            "name": "Alxarafe\\Core\\InitializerAbstract::enabled",
            "doc": "&quot;Code to load  when module is enabled.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\InitializerAbstract",
            "fromLink": "Alxarafe/Core/InitializerAbstract.html",
            "link": "Alxarafe/Core/InitializerAbstract.html#method_disabled",
            "name": "Alxarafe\\Core\\InitializerAbstract::disabled",
            "doc": "&quot;Code to load  when module is disabled.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/Language.html",
            "name": "Alxarafe\\Core\\Models\\Language",
            "doc": "&quot;Class Language&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Language",
            "fromLink": "Alxarafe/Core/Models/Language.html",
            "link": "Alxarafe/Core/Models/Language.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\Language::__construct",
            "doc": "&quot;Language constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Language",
            "fromLink": "Alxarafe/Core/Models/Language.html",
            "link": "Alxarafe/Core/Models/Language.html#method_getNameField",
            "name": "Alxarafe\\Core\\Models\\Language::getNameField",
            "doc": "&quot;Returns the name of the identification field of the record. By default it will be name.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/Module.html",
            "name": "Alxarafe\\Core\\Models\\Module",
            "doc": "&quot;Class Module&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Module",
            "fromLink": "Alxarafe/Core/Models/Module.html",
            "link": "Alxarafe/Core/Models/Module.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\Module::__construct",
            "doc": "&quot;Module constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Module",
            "fromLink": "Alxarafe/Core/Models/Module.html",
            "link": "Alxarafe/Core/Models/Module.html#method_getEnabledModules",
            "name": "Alxarafe\\Core\\Models\\Module::getEnabledModules",
            "doc": "&quot;Returns an ordered list of enabled modules.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Module",
            "fromLink": "Alxarafe/Core/Models/Module.html",
            "link": "Alxarafe/Core/Models/Module.html#method_getAllModules",
            "name": "Alxarafe\\Core\\Models\\Module::getAllModules",
            "doc": "&quot;Returns a list of modules.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/Page.html",
            "name": "Alxarafe\\Core\\Models\\Page",
            "doc": "&quot;Class Page&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Page",
            "fromLink": "Alxarafe/Core/Models/Page.html",
            "link": "Alxarafe/Core/Models/Page.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\Page::__construct",
            "doc": "&quot;Page constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/Role.html",
            "name": "Alxarafe\\Core\\Models\\Role",
            "doc": "&quot;Class Role. Define the roles available in the application. By default, the administrator\nand the user are defined.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\Role",
            "fromLink": "Alxarafe/Core/Models/Role.html",
            "link": "Alxarafe/Core/Models/Role.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\Role::__construct",
            "doc": "&quot;Role constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/RolePage.html",
            "name": "Alxarafe\\Core\\Models\\RolePage",
            "doc": "&quot;Class RolePage. Link each role with the assigned page.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\RolePage",
            "fromLink": "Alxarafe/Core/Models/RolePage.html",
            "link": "Alxarafe/Core/Models/RolePage.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\RolePage::__construct",
            "doc": "&quot;RolePage constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/TableModel.html",
            "name": "Alxarafe\\Core\\Models\\TableModel",
            "doc": "&quot;Class TableModel&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\TableModel",
            "fromLink": "Alxarafe/Core/Models/TableModel.html",
            "link": "Alxarafe/Core/Models/TableModel.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\TableModel::__construct",
            "doc": "&quot;TableModel constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\TableModel",
            "fromLink": "Alxarafe/Core/Models/TableModel.html",
            "link": "Alxarafe/Core/Models/TableModel.html#method_getDependencies",
            "name": "Alxarafe\\Core\\Models\\TableModel::getDependencies",
            "doc": "&quot;Return class dependencies&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/User.html",
            "name": "Alxarafe\\Core\\Models\\User",
            "doc": "&quot;Class Users&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\User",
            "fromLink": "Alxarafe/Core/Models/User.html",
            "link": "Alxarafe/Core/Models/User.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\User::__construct",
            "doc": "&quot;User constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\User",
            "fromLink": "Alxarafe/Core/Models/User.html",
            "link": "Alxarafe/Core/Models/User.html#method_verifyLogKey",
            "name": "Alxarafe\\Core\\Models\\User::verifyLogKey",
            "doc": "&quot;Verify is log key is correct.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\User",
            "fromLink": "Alxarafe/Core/Models/User.html",
            "link": "Alxarafe/Core/Models/User.html#method_verifyPassword",
            "name": "Alxarafe\\Core\\Models\\User::verifyPassword",
            "doc": "&quot;Verify that user password was valid.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\User",
            "fromLink": "Alxarafe/Core/Models/User.html",
            "link": "Alxarafe/Core/Models/User.html#method_generateLogKey",
            "name": "Alxarafe\\Core\\Models\\User::generateLogKey",
            "doc": "&quot;Generate a log key.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Models",
            "fromLink": "Alxarafe/Core/Models.html",
            "link": "Alxarafe/Core/Models/UserRole.html",
            "name": "Alxarafe\\Core\\Models\\UserRole",
            "doc": "&quot;Class UserRoles. Link each user with the assigned roles.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Models\\UserRole",
            "fromLink": "Alxarafe/Core/Models/UserRole.html",
            "link": "Alxarafe/Core/Models/UserRole.html#method___construct",
            "name": "Alxarafe\\Core\\Models\\UserRole::__construct",
            "doc": "&quot;UserRole constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\PreProcessors",
            "fromLink": "Alxarafe/Core/PreProcessors.html",
            "link": "Alxarafe/Core/PreProcessors/Languages.html",
            "name": "Alxarafe\\Core\\PreProcessors\\Languages",
            "doc": "&quot;This class pre-process pages to generate some needed information.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Languages",
            "fromLink": "Alxarafe/Core/PreProcessors/Languages.html",
            "link": "Alxarafe/Core/PreProcessors/Languages.html#method_exportLanguages",
            "name": "Alxarafe\\Core\\PreProcessors\\Languages::exportLanguages",
            "doc": "&quot;The best way to get the list is still to be determined, as well as if\ndomains are going to be used.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\PreProcessors",
            "fromLink": "Alxarafe/Core/PreProcessors.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html",
            "name": "Alxarafe\\Core\\PreProcessors\\Models",
            "doc": "&quot;This class pre-process Models to generate some needed information.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method___construct",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::__construct",
            "doc": "&quot;Models constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method_instantiateModels",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::instantiateModels",
            "doc": "&quot;Instantiate all available models&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method_fillList",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::fillList",
            "doc": "&quot;Fill list of classes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method_addClassDependencies",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::addClassDependencies",
            "doc": "&quot;Load class dependencies before load direct class.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method_addClassFirst",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::addClassFirst",
            "doc": "&quot;Load class only if not yet loaded.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method_addClass",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::addClass",
            "doc": "&quot;Load class only if not yet loaded.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Models",
            "fromLink": "Alxarafe/Core/PreProcessors/Models.html",
            "link": "Alxarafe/Core/PreProcessors/Models.html#method_addTableData",
            "name": "Alxarafe\\Core\\PreProcessors\\Models::addTableData",
            "doc": "&quot;Adds Model needed data to TableModel.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\PreProcessors",
            "fromLink": "Alxarafe/Core/PreProcessors.html",
            "link": "Alxarafe/Core/PreProcessors/Pages.html",
            "name": "Alxarafe\\Core\\PreProcessors\\Pages",
            "doc": "&quot;This class pre-process pages to generate some needed information.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Pages",
            "fromLink": "Alxarafe/Core/PreProcessors/Pages.html",
            "link": "Alxarafe/Core/PreProcessors/Pages.html#method___construct",
            "name": "Alxarafe\\Core\\PreProcessors\\Pages::__construct",
            "doc": "&quot;Models constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Pages",
            "fromLink": "Alxarafe/Core/PreProcessors/Pages.html",
            "link": "Alxarafe/Core/PreProcessors/Pages.html#method_updatePageDetails",
            "name": "Alxarafe\\Core\\PreProcessors\\Pages::updatePageDetails",
            "doc": "&quot;Updates active page field based on enabled namespaces&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Pages",
            "fromLink": "Alxarafe/Core/PreProcessors/Pages.html",
            "link": "Alxarafe/Core/PreProcessors/Pages.html#method_checkPageControllers",
            "name": "Alxarafe\\Core\\PreProcessors\\Pages::checkPageControllers",
            "doc": "&quot;Check all clases that extends from PageController, an store it to pages table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Pages",
            "fromLink": "Alxarafe/Core/PreProcessors/Pages.html",
            "link": "Alxarafe/Core/PreProcessors/Pages.html#method_instantiateClass",
            "name": "Alxarafe\\Core\\PreProcessors\\Pages::instantiateClass",
            "doc": "&quot;Instanciate class and update page data if needed.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Pages",
            "fromLink": "Alxarafe/Core/PreProcessors/Pages.html",
            "link": "Alxarafe/Core/PreProcessors/Pages.html#method_updatePageData",
            "name": "Alxarafe\\Core\\PreProcessors\\Pages::updatePageData",
            "doc": "&quot;Updates the page data if needed.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\PreProcessors",
            "fromLink": "Alxarafe/Core/PreProcessors.html",
            "link": "Alxarafe/Core/PreProcessors/Routes.html",
            "name": "Alxarafe\\Core\\PreProcessors\\Routes",
            "doc": "&quot;This class pre-process pages to generate some needed information.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Routes",
            "fromLink": "Alxarafe/Core/PreProcessors/Routes.html",
            "link": "Alxarafe/Core/PreProcessors/Routes.html#method___construct",
            "name": "Alxarafe\\Core\\PreProcessors\\Routes::__construct",
            "doc": "&quot;Models constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Routes",
            "fromLink": "Alxarafe/Core/PreProcessors/Routes.html",
            "link": "Alxarafe/Core/PreProcessors/Routes.html#method_checkRoutesControllers",
            "name": "Alxarafe\\Core\\PreProcessors\\Routes::checkRoutesControllers",
            "doc": "&quot;Check all clases that extends from PageController, an store it to pages table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\PreProcessors\\Routes",
            "fromLink": "Alxarafe/Core/PreProcessors/Routes.html",
            "link": "Alxarafe/Core/PreProcessors/Routes.html#method_instantiateClass",
            "name": "Alxarafe\\Core\\PreProcessors\\Routes::instantiateClass",
            "doc": "&quot;Instanciate class and update page data if needed.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Config.html",
            "name": "Alxarafe\\Core\\Providers\\Config",
            "doc": "&quot;Class ConfigurationManager&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\Config::__construct",
            "doc": "&quot;ConfigurationManager constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method_getConfigContent",
            "name": "Alxarafe\\Core\\Providers\\Config::getConfigContent",
            "doc": "&quot;Returns the config content.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Config::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Config::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method_loadConfigConstants",
            "name": "Alxarafe\\Core\\Providers\\Config::loadConfigConstants",
            "doc": "&quot;Loads some constants from config file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method_loadConstants",
            "name": "Alxarafe\\Core\\Providers\\Config::loadConstants",
            "doc": "&quot;Loads some constants.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Config",
            "fromLink": "Alxarafe/Core/Providers/Config.html",
            "link": "Alxarafe/Core/Providers/Config.html#method_configFileExists",
            "name": "Alxarafe\\Core\\Providers\\Config::configFileExists",
            "doc": "&quot;Return true y the config file exists&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Container.html",
            "name": "Alxarafe\\Core\\Providers\\Container",
            "doc": "&quot;Class Container&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Container",
            "fromLink": "Alxarafe/Core/Providers/Container.html",
            "link": "Alxarafe/Core/Providers/Container.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\Container::__construct",
            "doc": "&quot;Container constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Container",
            "fromLink": "Alxarafe/Core/Providers/Container.html",
            "link": "Alxarafe/Core/Providers/Container.html#method_getContainer",
            "name": "Alxarafe\\Core\\Providers\\Container::getContainer",
            "doc": "&quot;Return the full container.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Container",
            "fromLink": "Alxarafe/Core/Providers/Container.html",
            "link": "Alxarafe/Core/Providers/Container.html#method_add",
            "name": "Alxarafe\\Core\\Providers\\Container::add",
            "doc": "&quot;Add new object to the container.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Container",
            "fromLink": "Alxarafe/Core/Providers/Container.html",
            "link": "Alxarafe/Core/Providers/Container.html#method_get",
            "name": "Alxarafe\\Core\\Providers\\Container::get",
            "doc": "&quot;Returns and object from the container if exists, or null.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Container",
            "fromLink": "Alxarafe/Core/Providers/Container.html",
            "link": "Alxarafe/Core/Providers/Container.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Container::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Container",
            "fromLink": "Alxarafe/Core/Providers/Container.html",
            "link": "Alxarafe/Core/Providers/Container.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Container::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Database.html",
            "name": "Alxarafe\\Core\\Providers\\Database",
            "doc": "&quot;Class Database&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\Database::__construct",
            "doc": "&quot;Database constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Database::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Database::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method_connectToDatabase",
            "name": "Alxarafe\\Core\\Providers\\Database::connectToDatabase",
            "doc": "&quot;If Database::getInstance()-&gt;getDbEngine() contain null, create an Engine instance with the database connection\nand assigns it to Database::getInstance()-&gt;getDbEngine().&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method_getDbEngine",
            "name": "Alxarafe\\Core\\Providers\\Database::getDbEngine",
            "doc": "&quot;Returns the database engine.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method_getSqlHelper",
            "name": "Alxarafe\\Core\\Providers\\Database::getSqlHelper",
            "doc": "&quot;Return the sql helper for the engine in use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Database",
            "fromLink": "Alxarafe/Core/Providers/Database.html",
            "link": "Alxarafe/Core/Providers/Database.html#method_getConnectionData",
            "name": "Alxarafe\\Core\\Providers\\Database::getConnectionData",
            "doc": "&quot;Returns the connections data details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html",
            "name": "Alxarafe\\Core\\Providers\\DebugTool",
            "doc": "&quot;Class DebugTool&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::__construct",
            "doc": "&quot;DebugTool constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_startTimer",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::startTimer",
            "doc": "&quot;Start a timer by name and message&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_addMessage",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::addMessage",
            "doc": "&quot;Write a message in a channel (tab) of the debug bar.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_stopTimer",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::stopTimer",
            "doc": "&quot;Stop a timer by name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_addException",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::addException",
            "doc": "&quot;Add a new exception to the debug bar.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_getDebugTool",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::getDebugTool",
            "doc": "&quot;Return the internal debug instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_getRenderHeader",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::getRenderHeader",
            "doc": "&quot;Return the render header needed when debug is enabled. Otherwise return an empty string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\DebugTool",
            "fromLink": "Alxarafe/Core/Providers/DebugTool.html",
            "link": "Alxarafe/Core/Providers/DebugTool.html#method_getRenderFooter",
            "name": "Alxarafe\\Core\\Providers\\DebugTool::getRenderFooter",
            "doc": "&quot;Return the render footer needed when debug is enabled. Otherwise return an empty string.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages",
            "doc": "&quot;Class FlashMessages&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::__construct",
            "doc": "&quot;Container constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_getContainer",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::getContainer",
            "doc": "&quot;Return the full container.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_setError",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::setError",
            "doc": "&quot;Register a new error message&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_setFlash",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::setFlash",
            "doc": "&quot;Set flash message.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_setWarning",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::setWarning",
            "doc": "&quot;Register a new warning message&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_setInfo",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::setInfo",
            "doc": "&quot;Register a new info message&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_setSuccess",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::setSuccess",
            "doc": "&quot;Register a new error message&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\FlashMessages",
            "fromLink": "Alxarafe/Core/Providers/FlashMessages.html",
            "link": "Alxarafe/Core/Providers/FlashMessages.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\FlashMessages::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Logger.html",
            "name": "Alxarafe\\Core\\Providers\\Logger",
            "doc": "&quot;Class Logger&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Logger",
            "fromLink": "Alxarafe/Core/Providers/Logger.html",
            "link": "Alxarafe/Core/Providers/Logger.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\Logger::__construct",
            "doc": "&quot;Logger constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Logger",
            "fromLink": "Alxarafe/Core/Providers/Logger.html",
            "link": "Alxarafe/Core/Providers/Logger.html#method_exceptionHandler",
            "name": "Alxarafe\\Core\\Providers\\Logger::exceptionHandler",
            "doc": "&quot;Catch the exception handler and adds to logger.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Logger",
            "fromLink": "Alxarafe/Core/Providers/Logger.html",
            "link": "Alxarafe/Core/Providers/Logger.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Logger::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Logger",
            "fromLink": "Alxarafe/Core/Providers/Logger.html",
            "link": "Alxarafe/Core/Providers/Logger.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Logger::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Logger",
            "fromLink": "Alxarafe/Core/Providers/Logger.html",
            "link": "Alxarafe/Core/Providers/Logger.html#method_getLogger",
            "name": "Alxarafe\\Core\\Providers\\Logger::getLogger",
            "doc": "&quot;Returns the logger.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager",
            "doc": "&quot;Class ModuleManager&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::__construct",
            "doc": "&quot;Container constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getModules",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getModules",
            "doc": "&quot;Return the full modules from database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getEnabledModules",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getEnabledModules",
            "doc": "&quot;Return a list of enabled modules from database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_initializeModules",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::initializeModules",
            "doc": "&quot;Initialize modules.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_addTranslatorFolders",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::addTranslatorFolders",
            "doc": "&quot;Adds enabled module folders to translator.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getFoldersEnabledModules",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getFoldersEnabledModules",
            "doc": "&quot;Returns a list of folder from enabled modules.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_addRenderFolders",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::addRenderFolders",
            "doc": "&quot;Adds enabled module folders to renderer.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_runInitializer",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::runInitializer",
            "doc": "&quot;Exec Initializer::init() from each enabled module.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_executePreprocesses",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::executePreprocesses",
            "doc": "&quot;Execute all preprocessors from one point.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_runPreprocessors",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::runPreprocessors",
            "doc": "&quot;Run preprocessors for update modules dependencies.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getEnabledFolders",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getEnabledFolders",
            "doc": "&quot;Return a list of enabled folders.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_enableModule",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::enableModule",
            "doc": "&quot;Enable a module.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_disableModule",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::disableModule",
            "doc": "&quot;Disable a module.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\ModuleManager",
            "fromLink": "Alxarafe/Core/Providers/ModuleManager.html",
            "link": "Alxarafe/Core/Providers/ModuleManager.html#method_getConfig",
            "name": "Alxarafe\\Core\\Providers\\ModuleManager::getConfig",
            "doc": "&quot;Returns the data from database.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "doc": "&quot;Class RegionalInfo&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::__construct",
            "doc": "&quot;Container constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_getConfigContent",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::getConfigContent",
            "doc": "&quot;Returns the config content.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_getDateFormats",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::getDateFormats",
            "doc": "&quot;Returns a list of date formats&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_fillList",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::fillList",
            "doc": "&quot;Fill list with key =&gt; value, where key is style and value a sample.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_getFormatted",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::getFormatted",
            "doc": "&quot;Return formatted string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\RegionalInfo",
            "fromLink": "Alxarafe/Core/Providers/RegionalInfo.html",
            "link": "Alxarafe/Core/Providers/RegionalInfo.html#method_getTimeFormats",
            "name": "Alxarafe\\Core\\Providers\\RegionalInfo::getTimeFormats",
            "doc": "&quot;Returns a list of time formats&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Router.html",
            "name": "Alxarafe\\Core\\Providers\\Router",
            "doc": "&quot;Class Routes\nA route is a pair key =&gt; value, where key is the short name of the controller and the value the FQCN&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\Router::__construct",
            "doc": "&quot;Routes constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_getRoutes",
            "name": "Alxarafe\\Core\\Providers\\Router::getRoutes",
            "doc": "&quot;Return a list of routes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_setRoutes",
            "name": "Alxarafe\\Core\\Providers\\Router::setRoutes",
            "doc": "&quot;Set a new list of routes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_loadRoutes",
            "name": "Alxarafe\\Core\\Providers\\Router::loadRoutes",
            "doc": "&quot;Load routes from configuration file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Router::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Router::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_saveRoutes",
            "name": "Alxarafe\\Core\\Providers\\Router::saveRoutes",
            "doc": "&quot;Saves routes to configuration file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_addRoute",
            "name": "Alxarafe\\Core\\Providers\\Router::addRoute",
            "doc": "&quot;Add a new route if is not yet added.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_hasRoute",
            "name": "Alxarafe\\Core\\Providers\\Router::hasRoute",
            "doc": "&quot;Returns if route is setted.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Router",
            "fromLink": "Alxarafe/Core/Providers/Router.html",
            "link": "Alxarafe/Core/Providers/Router.html#method_getRoute",
            "name": "Alxarafe\\Core\\Providers\\Router::getRoute",
            "doc": "&quot;Returns the FQCN if exists or null.&quot;"
        },

        {
            "type": "Trait",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Singleton.html",
            "name": "Alxarafe\\Core\\Providers\\Singleton",
            "doc": "&quot;Trait Singleton, This class ensures that all class that use this have only one instance of itself if called as:\nClass::getInstance()&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getInstance",
            "doc": "&quot;The object is created from within the class itself only if the class\nhas no instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getClassName",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getClassName",
            "doc": "&quot;Returns the class name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_setConfig",
            "name": "Alxarafe\\Core\\Providers\\Singleton::setConfig",
            "doc": "&quot;Save config to file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getYamlContent",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getYamlContent",
            "doc": "&quot;Returns the content of the Yaml file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getFilePath",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getFilePath",
            "doc": "&quot;Return the full file config path.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getFileName",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getFileName",
            "doc": "&quot;Return the file name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_yamlName",
            "name": "Alxarafe\\Core\\Providers\\Singleton::yamlName",
            "doc": "&quot;Return the classname for yaml file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_fileExists",
            "name": "Alxarafe\\Core\\Providers\\Singleton::fileExists",
            "doc": "&quot;Returns if file exists.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getConfig",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getConfig",
            "doc": "&quot;Returns the yaml config params.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_getBasePath",
            "name": "Alxarafe\\Core\\Providers\\Singleton::getBasePath",
            "doc": "&quot;Return the base path.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Singleton",
            "fromLink": "Alxarafe/Core/Providers/Singleton.html",
            "link": "Alxarafe/Core/Providers/Singleton.html#method_initSingleton",
            "name": "Alxarafe\\Core\\Providers\\Singleton::initSingleton",
            "doc": "&quot;Initialization, equivalent to __construct and must be called from main class.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender",
            "doc": "&quot;Class TemplateRender&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::__construct",
            "doc": "&quot;TemplateRender constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_setSkin",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::setSkin",
            "doc": "&quot;Set a skin.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_setTemplatesFolder",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::setTemplatesFolder",
            "doc": "&quot;Establish a new template. The parameter must be only de template name, no the path!&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getTemplatesFolder",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getTemplatesFolder",
            "doc": "&quot;Return the template folder path.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getPaths",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getPaths",
            "doc": "&quot;Returns a list of available paths.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getCommonTemplatesFolder",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getCommonTemplatesFolder",
            "doc": "&quot;Return the common template folder path.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_addDirs",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::addDirs",
            "doc": "&quot;Add additional language folders.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_setTwig",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::setTwig",
            "doc": "&quot;Sets a new twig environment.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_render",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::render",
            "doc": "&quot;Renders a template.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getTwig",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getTwig",
            "doc": "&quot;Return the full twig environtment.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getOptions",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getOptions",
            "doc": "&quot;Returns a list of options.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_addExtensions",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::addExtensions",
            "doc": "&quot;Add extensions to skin render.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_loadPaths",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::loadPaths",
            "doc": "&quot;Load paths, including modules.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getTemplate",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getTemplate",
            "doc": "&quot;Return the assigned template to use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getTemplateVars",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getTemplateVars",
            "doc": "&quot;Return a list of template vars, merged with $vars,&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_setTemplate",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::setTemplate",
            "doc": "&quot;Sets the new template to use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_hasTemplate",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::hasTemplate",
            "doc": "&quot;Returns true if a template has been specified.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_addVars",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::addVars",
            "doc": "&quot;Add vars to template vars.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getSkins",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getSkins",
            "doc": "&quot;Returns an array with the list of skins (folders inside the folder specified for the templates).&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getResourceUri",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getResourceUri",
            "doc": "&quot;Check different possible locations for the file and return the\ncorresponding URI, if it exists.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getTemplatesUri",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getTemplatesUri",
            "doc": "&quot;Return the template folder path from uri.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\TemplateRender",
            "fromLink": "Alxarafe/Core/Providers/TemplateRender.html",
            "link": "Alxarafe/Core/Providers/TemplateRender.html#method_getCommonTemplatesUri",
            "name": "Alxarafe\\Core\\Providers\\TemplateRender::getCommonTemplatesUri",
            "doc": "&quot;Return the common template folder path from uri.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Providers",
            "fromLink": "Alxarafe/Core/Providers.html",
            "link": "Alxarafe/Core/Providers/Translator.html",
            "name": "Alxarafe\\Core\\Providers\\Translator",
            "doc": "&quot;Class Lang, give support to internationalization.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method___construct",
            "name": "Alxarafe\\Core\\Providers\\Translator::__construct",
            "doc": "&quot;Lang constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_loadLangFiles",
            "name": "Alxarafe\\Core\\Providers\\Translator::loadLangFiles",
            "doc": "&quot;Load the translation files following the priorities.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getLangFolders",
            "name": "Alxarafe\\Core\\Providers\\Translator::getLangFolders",
            "doc": "&quot;Return the lang folders.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getBaseLangFolder",
            "name": "Alxarafe\\Core\\Providers\\Translator::getBaseLangFolder",
            "doc": "&quot;Returns the base lang folder.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getInstance",
            "name": "Alxarafe\\Core\\Providers\\Translator::getInstance",
            "doc": "&quot;Return this instance.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getDefaultValues",
            "name": "Alxarafe\\Core\\Providers\\Translator::getDefaultValues",
            "doc": "&quot;Return default values&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_addDirs",
            "name": "Alxarafe\\Core\\Providers\\Translator::addDirs",
            "doc": "&quot;Add additional language folders.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_setlocale",
            "name": "Alxarafe\\Core\\Providers\\Translator::setlocale",
            "doc": "&quot;Sets the language code in use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getAvailableLanguages",
            "name": "Alxarafe\\Core\\Providers\\Translator::getAvailableLanguages",
            "doc": "&quot;Returns an array with the languages with available translations.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_trans",
            "name": "Alxarafe\\Core\\Providers\\Translator::trans",
            "doc": "&quot;Translate the text into the default language.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_verifyMissing",
            "name": "Alxarafe\\Core\\Providers\\Translator::verifyMissing",
            "doc": "&quot;Stores if translation is used and if is missing.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getLocale",
            "name": "Alxarafe\\Core\\Providers\\Translator::getLocale",
            "doc": "&quot;Returns the language code in use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getMissingStrings",
            "name": "Alxarafe\\Core\\Providers\\Translator::getMissingStrings",
            "doc": "&quot;Returns the missing strings.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getUsedStrings",
            "name": "Alxarafe\\Core\\Providers\\Translator::getUsedStrings",
            "doc": "&quot;Returns the strings used.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Providers\\Translator",
            "fromLink": "Alxarafe/Core/Providers/Translator.html",
            "link": "Alxarafe/Core/Providers/Translator.html#method_getTranslator",
            "name": "Alxarafe\\Core\\Providers\\Translator::getTranslator",
            "doc": "&quot;Returns the original translator.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent",
            "doc": "&quot;Class AbstractComponent&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html#method___construct",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent::__construct",
            "doc": "&quot;AbstractComponent constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html#method_toHtml",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent::toHtml",
            "doc": "&quot;Return this component rendered.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html#method_getTemplatePath",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent::getTemplatePath",
            "doc": "&quot;Return the template path to render this component.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/AbstractComponent.html#method_toArray",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\AbstractComponent::toArray",
            "doc": "&quot;Returns this object public properties to array.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/Alert.html",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\Alert",
            "doc": "&quot;Class Alert component&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components\\Alert",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components/Alert.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/Alert.html#method_getTemplatePath",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\Alert::getTemplatePath",
            "doc": "&quot;Return the template path to render this component.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/Button.html",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\Button",
            "doc": "&quot;Class Button component&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Renders\\Twig\\Components\\Button",
            "fromLink": "Alxarafe/Core/Renders/Twig/Components/Button.html",
            "link": "Alxarafe/Core/Renders/Twig/Components/Button.html#method_getTemplatePath",
            "name": "Alxarafe\\Core\\Renders\\Twig\\Components\\Button::getTemplatePath",
            "doc": "&quot;Return the template path to render this component.&quot;"
        },

        {
            "type": "Trait",
            "fromName": "Alxarafe\\Core\\Traits",
            "fromLink": "Alxarafe/Core/Traits.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "doc": "&quot;Trait AjaxDataTable.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_ajaxTableDataMethod",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::ajaxTableDataMethod",
            "doc": "&quot;Return the table data using AJAX&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_initialize",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::initialize",
            "doc": "&quot;Initialize common properties&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_searchData",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::searchData",
            "doc": "&quot;Realize the search to database table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_getDefaultColumnsSearch",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::getDefaultColumnsSearch",
            "doc": "&quot;Return a default list of col.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_fillActions",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::fillActions",
            "doc": "&quot;Fill &#039;col-action&#039; fields with action buttons.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_getActionButtons",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::getActionButtons",
            "doc": "&quot;Returns a list of actions buttons. By default returns Read\/Update\/Delete actions.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_sendResponse",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::sendResponse",
            "doc": "&quot;Send the Response with data received.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_getTableHeader",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::getTableHeader",
            "doc": "&quot;Returns the header for table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_getTableBody",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::getTableBody",
            "doc": "&quot;Returns the content for the body of table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_getListFields",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::getListFields",
            "doc": "&quot;Returns a list of fields for the tablename.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait",
            "fromLink": "Alxarafe/Core/Traits/AjaxDataTableTrait.html",
            "link": "Alxarafe/Core/Traits/AjaxDataTableTrait.html#method_getTableFooter",
            "name": "Alxarafe\\Core\\Traits\\AjaxDataTableTrait::getTableFooter",
            "doc": "&quot;Returns a footer list of fields for the table.&quot;"
        },

        {
            "type": "Trait",
            "fromName": "Alxarafe\\Core\\Traits",
            "fromLink": "Alxarafe/Core/Traits.html",
            "link": "Alxarafe/Core/Traits/MagicTrait.html",
            "name": "Alxarafe\\Core\\Traits\\MagicTrait",
            "doc": "&quot;Trait MagicTrait. Contains magic methods: setter, getter, isset, call and has\nTo reduce code on pure PHP classes with good practices and recomendations.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\MagicTrait",
            "fromLink": "Alxarafe/Core/Traits/MagicTrait.html",
            "link": "Alxarafe/Core/Traits/MagicTrait.html#method___isset",
            "name": "Alxarafe\\Core\\Traits\\MagicTrait::__isset",
            "doc": "&quot;Magic isset.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\MagicTrait",
            "fromLink": "Alxarafe/Core/Traits/MagicTrait.html",
            "link": "Alxarafe/Core/Traits/MagicTrait.html#method___get",
            "name": "Alxarafe\\Core\\Traits\\MagicTrait::__get",
            "doc": "&quot;Magic getter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\MagicTrait",
            "fromLink": "Alxarafe/Core/Traits/MagicTrait.html",
            "link": "Alxarafe/Core/Traits/MagicTrait.html#method___set",
            "name": "Alxarafe\\Core\\Traits\\MagicTrait::__set",
            "doc": "&quot;Magic setter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Core\\Traits\\MagicTrait",
            "fromLink": "Alxarafe/Core/Traits/MagicTrait.html",
            "link": "Alxarafe/Core/Traits/MagicTrait.html#method___call",
            "name": "Alxarafe\\Core\\Traits\\MagicTrait::__call",
            "doc": "&quot;Intercepts calls to non-existent getters \/ setters\nLooks at the beginning of $method to see if it&#039;s \&quot;get\&quot;, \&quot;set\&quot;, \&quot;has\&quot;\nUses preg_match() to extract the 2nd part of the match, which should produce the property name&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Autoload",
            "fromLink": "Alxarafe/Test/Core/Autoload.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "fromLink": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "fromLink": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html#method_testGetInstance",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest::testGetInstance",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "fromLink": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html#method_testInit",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest::testInit",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "fromLink": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html#method_testAddDirs",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest::testAddDirs",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "fromLink": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html#method_testAutoLoad",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest::testAutoLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Autoload\\LoadTest",
            "fromLink": "Alxarafe/Test/Core/Autoload/LoadTest.html",
            "link": "Alxarafe/Test/Core/Autoload/LoadTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Autoload\\LoadTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Base",
            "fromLink": "Alxarafe/Test/Core/Base.html",
            "link": "Alxarafe/Test/Core/Base/AuthControllerTest.html",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthControllerTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthControllerTest.html#method_testLogin",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest::testLogin",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthControllerTest.html#method_newClient",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest::newClient",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthControllerTest.html#method_doGetRequest",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest::doGetRequest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthControllerTest.html#method_testLogout",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthControllerTest::testLogout",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Base",
            "fromLink": "Alxarafe/Test/Core/Base.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testReadMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testReadMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testDeleteMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testDeleteMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testUpdateMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testUpdateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testRunMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testRunMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testGetUserMenu",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testGetUserMenu",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testPageDetails",
            "doc": "&quot;AuthPageController::pageDetails&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testCreateMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testCreateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageControllerTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageControllerTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Base",
            "fromLink": "Alxarafe/Test/Core/Base.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testShowMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testShowMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testGetActionButtons",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testGetActionButtons",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testGetExtraActions",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testGetExtraActions",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testEditMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testEditMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testRemoveMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testRemoveMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testInitialize",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testInitialize",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testDeleteMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testDeleteMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testAddMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testAddMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testCreateMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testCreateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testAccessDenied",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testAccessDenied",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testListData",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testListData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testReadMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testReadMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/AuthPageExtendedControllerTest.html#method_testUpdateMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\AuthPageExtendedControllerTest::testUpdateMethod",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Base",
            "fromLink": "Alxarafe/Test/Core/Base.html",
            "link": "Alxarafe/Test/Core/Base/CacheCoreTest.html",
            "name": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest",
            "fromLink": "Alxarafe/Test/Core/Base/CacheCoreTest.html",
            "link": "Alxarafe/Test/Core/Base/CacheCoreTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest",
            "fromLink": "Alxarafe/Test/Core/Base/CacheCoreTest.html",
            "link": "Alxarafe/Test/Core/Base/CacheCoreTest.html#method_testGetInstance",
            "name": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest::testGetInstance",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest",
            "fromLink": "Alxarafe/Test/Core/Base/CacheCoreTest.html",
            "link": "Alxarafe/Test/Core/Base/CacheCoreTest.html#method_testGetEngine",
            "name": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest::testGetEngine",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest",
            "fromLink": "Alxarafe/Test/Core/Base/CacheCoreTest.html",
            "link": "Alxarafe/Test/Core/Base/CacheCoreTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Base\\CacheCoreTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Base",
            "fromLink": "Alxarafe/Test/Core/Base.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testAddResource",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testAddResource",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testGetArrayPost",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testGetArrayPost",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testSendResponse",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testSendResponse",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testSendResponseTemplate",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testSendResponseTemplate",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testGetArrayCookies",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testGetArrayCookies",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testRunMethod",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testRunMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testAddCSS",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testAddCSS",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testAddToVar",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testAddToVar",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testGetArrayServer",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testGetArrayServer",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testGetArrayHeaders",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testGetArrayHeaders",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testGetArrayGet",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testGetArrayGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testRedirect",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testRedirect",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testAddJS",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testAddJS",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Base\\ControllerTest",
            "fromLink": "Alxarafe/Test/Core/Base/ControllerTest.html",
            "link": "Alxarafe/Test/Core/Base/ControllerTest.html#method_testGetArrayFiles",
            "name": "Alxarafe\\Test\\Core\\Base\\ControllerTest::testGetArrayFiles",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest::testPageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html#method_testGenerateMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest::testGenerateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/CreateConfigTest.html#method_testGetTimezoneList",
            "name": "Alxarafe\\Test\\Core\\Controllers\\CreateConfigTest::testGetTimezoneList",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "doc": "&quot;Class EditConfigTest&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testReadMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testReadMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testUpdateMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testUpdateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testCreateMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testCreateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testDeleteMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testDeleteMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testPageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_testGetTimezoneList",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::testGetTimezoneList",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/EditConfigTest.html",
            "link": "Alxarafe/Test/Core/Controllers/EditConfigTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\EditConfigTest::tearDown",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/LanguagesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LanguagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LanguagesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LanguagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LanguagesTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LanguagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LanguagesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LanguagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LanguagesTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LanguagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LanguagesTest.html#method_testGetExtraActions",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LanguagesTest::testGetExtraActions",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testGetCookieUser",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testGetCookieUser",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testSetUser",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testSetUser",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testLogoutMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testLogoutMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testPageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testGetUser",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testGetUser",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\LoginTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/LoginTest.html",
            "link": "Alxarafe/Test/Core/Controllers/LoginTest.html#method_testGetUserName",
            "name": "Alxarafe\\Test\\Core\\Controllers\\LoginTest::testGetUserName",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testReadMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testReadMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testDisableMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testDisableMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testDeleteMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testDeleteMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testGetActionButtons",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testGetActionButtons",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testIndexMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testIndexMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testCreateMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testCreateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testUpdateMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testUpdateMethod",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/ModulesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/ModulesTest.html#method_testEnableMethod",
            "name": "Alxarafe\\Test\\Core\\Controllers\\ModulesTest::testEnableMethod",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/PagesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\PagesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\PagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/PagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/PagesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\PagesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\PagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/PagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/PagesTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\PagesTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\PagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/PagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/PagesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\PagesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesPagesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesPagesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\RolesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/RolesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\RolesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/RolesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\RolesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/RolesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/RolesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\RolesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/TablesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\TablesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\TablesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/TablesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/TablesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\TablesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\TablesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/TablesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/TablesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\TablesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersRolesTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersRolesTest::testPageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Controllers",
            "fromLink": "Alxarafe/Test/Core/Controllers.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersTest.html",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\UsersTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/UsersTest.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\UsersTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/UsersTest.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Controllers\\UsersTest",
            "fromLink": "Alxarafe/Test/Core/Controllers/UsersTest.html",
            "link": "Alxarafe/Test/Core/Controllers/UsersTest.html#method_testPageDetails",
            "name": "Alxarafe\\Test\\Core\\Controllers\\UsersTest::testPageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Helpers",
            "fromLink": "Alxarafe/Test/Core/Helpers.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "doc": "&quot;Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:25:12.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormatDate",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormatDate",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormatDateTime",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormatDateTime",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormatTime",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormatTime",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormattedDate",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormattedDate",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormatted",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormatted",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormattedTime",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormattedTime",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_testGetFormattedDateTime",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::testGetFormattedDateTime",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/FormatUtilsTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Helpers\\FormatUtilsTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "doc": "&quot;Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:29:42.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method_testflatArray",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::testflatArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method_testAddToArray",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::testAddToArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method_testIsTrue",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::testIsTrue",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method_testGetItem",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::testGetItem",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method_testArrayMergeRecursiveEx",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::testArrayMergeRecursiveEx",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ArrayUtilsTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ArrayUtilsTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest",
            "doc": "&quot;Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:29:42.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html#method_testDefineIfNotExists",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest::testDefineIfNotExists",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html#method_testGetShortName",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest::testGetShortName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/ClassUtilsTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\ClassUtilsTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest",
            "doc": "&quot;Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:29:42.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html#method_testScandir",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest::testScandir",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html#method_testMkdir",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest::testMkdir",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html#method_testRrmdir",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest::testRrmdir",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/FileSystemUtilsTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\FileSystemUtilsTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest",
            "doc": "&quot;Generated by PHPUnit_SkeletonGenerator on 2019-03-05 at 15:29:42.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html#method_testCamelToSnake",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest::testCamelToSnake",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html#method_testSnakeToCamel",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest::testSnakeToCamel",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html#method_testRandomString",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest::testRandomString",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest",
            "fromLink": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html",
            "link": "Alxarafe/Test/Core/Helpers/Utils/TextUtilsTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Helpers\\Utils\\TextUtilsTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\LanguageTest",
            "fromLink": "Alxarafe/Test/Core/Models/LanguageTest.html",
            "link": "Alxarafe/Test/Core/Models/LanguageTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\LanguageTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetEnabledModules",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetEnabledModules",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetAllModules",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetAllModules",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\ModuleTest",
            "fromLink": "Alxarafe/Test/Core/Models/ModuleTest.html",
            "link": "Alxarafe/Test/Core/Models/ModuleTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\ModuleTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\PageTest",
            "fromLink": "Alxarafe/Test/Core/Models/PageTest.html",
            "link": "Alxarafe/Test/Core/Models/PageTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\PageTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RolePageTest",
            "fromLink": "Alxarafe/Test/Core/Models/RolePageTest.html",
            "link": "Alxarafe/Test/Core/Models/RolePageTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\RolePageTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\RoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/RoleTest.html",
            "link": "Alxarafe/Test/Core/Models/RoleTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\RoleTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetDependencies",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetDependencies",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\TableModelTest",
            "fromLink": "Alxarafe/Test/Core/Models/TableModelTest.html",
            "link": "Alxarafe/Test/Core/Models/TableModelTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\TableModelTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserRoleTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserRoleTest.html",
            "link": "Alxarafe/Test/Core/Models/UserRoleTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\UserRoleTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Test\\Core\\Models",
            "fromLink": "Alxarafe/Test/Core/Models.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method___construct",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::__construct",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testLoad",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testLoad",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetDataArray",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetDataArray",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetIndexesFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetIndexesFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_test__call",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::test__call",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSetData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGenerateLogKey",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGenerateLogKey",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSave",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSave",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSaveRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSaveRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_test__isset",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::test__isset",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetFieldsFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetFieldsFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testCheckStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testCheckStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testVerifyPassword",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testVerifyPassword",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetAllRecordsPaged",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetAllRecordsPaged",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testDelete",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testDelete",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSearch",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSearch",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetNameField",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetNameField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetIdByName",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetIdByName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetIdField",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetIdField",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSearchQuery",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSearchQuery",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGet",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGet",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_test__get",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::test__get",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSetOldData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSetOldData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testVerifyLogKey",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testVerifyLogKey",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetData",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetData",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_test__set",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::test__set",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetDefaultValues",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetDefaultValues",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetBy",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testCountAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testCountAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetAllRecordsBy",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetAllRecordsBy",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetAllRecords",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetAllRecords",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetChecksFromTable",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetChecksFromTable",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testNewRecord",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testNewRecord",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetQuotedTableName",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetQuotedTableName",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetId",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetId",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testGetStructure",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testGetStructure",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_testSearchCount",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::testSearchCount",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Test\\Core\\Models\\UserTest",
            "fromLink": "Alxarafe/Test/Core/Models/UserTest.html",
            "link": "Alxarafe/Test/Core/Models/UserTest.html#method_tearDown",
            "name": "Alxarafe\\Test\\Core\\Models\\UserTest::tearDown",
            "doc": "&quot;Tears down the fixture, for example, closes a network connection.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Controllers",
            "fromLink": "Modules/Sample/Controllers.html",
            "link": "Modules/Sample/Controllers/Countries.html",
            "name": "Modules\\Sample\\Controllers\\Countries",
            "doc": "&quot;Class Countries&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\Countries",
            "fromLink": "Modules/Sample/Controllers/Countries.html",
            "link": "Modules/Sample/Controllers/Countries.html#method___construct",
            "name": "Modules\\Sample\\Controllers\\Countries::__construct",
            "doc": "&quot;Countries constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\Countries",
            "fromLink": "Modules/Sample/Controllers/Countries.html",
            "link": "Modules/Sample/Controllers/Countries.html#method_pageDetails",
            "name": "Modules\\Sample\\Controllers\\Countries::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Controllers",
            "fromLink": "Modules/Sample/Controllers.html",
            "link": "Modules/Sample/Controllers/IntermediateRegions.html",
            "name": "Modules\\Sample\\Controllers\\IntermediateRegions",
            "doc": "&quot;Class IntermediateRegions&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\IntermediateRegions",
            "fromLink": "Modules/Sample/Controllers/IntermediateRegions.html",
            "link": "Modules/Sample/Controllers/IntermediateRegions.html#method___construct",
            "name": "Modules\\Sample\\Controllers\\IntermediateRegions::__construct",
            "doc": "&quot;IntermediateRegions constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\IntermediateRegions",
            "fromLink": "Modules/Sample/Controllers/IntermediateRegions.html",
            "link": "Modules/Sample/Controllers/IntermediateRegions.html#method_pageDetails",
            "name": "Modules\\Sample\\Controllers\\IntermediateRegions::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Controllers",
            "fromLink": "Modules/Sample/Controllers.html",
            "link": "Modules/Sample/Controllers/People.html",
            "name": "Modules\\Sample\\Controllers\\People",
            "doc": "&quot;Class People&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\People",
            "fromLink": "Modules/Sample/Controllers/People.html",
            "link": "Modules/Sample/Controllers/People.html#method___construct",
            "name": "Modules\\Sample\\Controllers\\People::__construct",
            "doc": "&quot;People constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\People",
            "fromLink": "Modules/Sample/Controllers/People.html",
            "link": "Modules/Sample/Controllers/People.html#method_pageDetails",
            "name": "Modules\\Sample\\Controllers\\People::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Controllers",
            "fromLink": "Modules/Sample/Controllers.html",
            "link": "Modules/Sample/Controllers/Regions.html",
            "name": "Modules\\Sample\\Controllers\\Regions",
            "doc": "&quot;Class Regions&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\Regions",
            "fromLink": "Modules/Sample/Controllers/Regions.html",
            "link": "Modules/Sample/Controllers/Regions.html#method___construct",
            "name": "Modules\\Sample\\Controllers\\Regions::__construct",
            "doc": "&quot;Regions constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\Regions",
            "fromLink": "Modules/Sample/Controllers/Regions.html",
            "link": "Modules/Sample/Controllers/Regions.html#method_pageDetails",
            "name": "Modules\\Sample\\Controllers\\Regions::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Controllers",
            "fromLink": "Modules/Sample/Controllers.html",
            "link": "Modules/Sample/Controllers/Subregions.html",
            "name": "Modules\\Sample\\Controllers\\Subregions",
            "doc": "&quot;Class Subregions&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\Subregions",
            "fromLink": "Modules/Sample/Controllers/Subregions.html",
            "link": "Modules/Sample/Controllers/Subregions.html#method___construct",
            "name": "Modules\\Sample\\Controllers\\Subregions::__construct",
            "doc": "&quot;Subregions constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Controllers\\Subregions",
            "fromLink": "Modules/Sample/Controllers/Subregions.html",
            "link": "Modules/Sample/Controllers/Subregions.html#method_pageDetails",
            "name": "Modules\\Sample\\Controllers\\Subregions::pageDetails",
            "doc": "&quot;Returns the page details.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Models",
            "fromLink": "Modules/Sample/Models.html",
            "link": "Modules/Sample/Models/Country.html",
            "name": "Modules\\Sample\\Models\\Country",
            "doc": "&quot;Class Country&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Country",
            "fromLink": "Modules/Sample/Models/Country.html",
            "link": "Modules/Sample/Models/Country.html#method___construct",
            "name": "Modules\\Sample\\Models\\Country::__construct",
            "doc": "&quot;Country constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Country",
            "fromLink": "Modules/Sample/Models/Country.html",
            "link": "Modules/Sample/Models/Country.html#method_getNameField",
            "name": "Modules\\Sample\\Models\\Country::getNameField",
            "doc": "&quot;Returns the name of the identification field of the record. By default it will be name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Country",
            "fromLink": "Modules/Sample/Models/Country.html",
            "link": "Modules/Sample/Models/Country.html#method_getDependencies",
            "name": "Modules\\Sample\\Models\\Country::getDependencies",
            "doc": "&quot;Return class dependencies&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Models",
            "fromLink": "Modules/Sample/Models.html",
            "link": "Modules/Sample/Models/IntermediateRegion.html",
            "name": "Modules\\Sample\\Models\\IntermediateRegion",
            "doc": "&quot;Class IntermediateRegion&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\IntermediateRegion",
            "fromLink": "Modules/Sample/Models/IntermediateRegion.html",
            "link": "Modules/Sample/Models/IntermediateRegion.html#method___construct",
            "name": "Modules\\Sample\\Models\\IntermediateRegion::__construct",
            "doc": "&quot;IntermediateRegion constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Models",
            "fromLink": "Modules/Sample/Models.html",
            "link": "Modules/Sample/Models/Person.html",
            "name": "Modules\\Sample\\Models\\Person",
            "doc": "&quot;Class Person&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Person",
            "fromLink": "Modules/Sample/Models/Person.html",
            "link": "Modules/Sample/Models/Person.html#method___construct",
            "name": "Modules\\Sample\\Models\\Person::__construct",
            "doc": "&quot;Person constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Person",
            "fromLink": "Modules/Sample/Models/Person.html",
            "link": "Modules/Sample/Models/Person.html#method_getNameField",
            "name": "Modules\\Sample\\Models\\Person::getNameField",
            "doc": "&quot;Returns the name of the identification field of the record. By default it will be name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Person",
            "fromLink": "Modules/Sample/Models/Person.html",
            "link": "Modules/Sample/Models/Person.html#method_getDependencies",
            "name": "Modules\\Sample\\Models\\Person::getDependencies",
            "doc": "&quot;Return class dependencies&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Models",
            "fromLink": "Modules/Sample/Models.html",
            "link": "Modules/Sample/Models/Region.html",
            "name": "Modules\\Sample\\Models\\Region",
            "doc": "&quot;Class Region&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Region",
            "fromLink": "Modules/Sample/Models/Region.html",
            "link": "Modules/Sample/Models/Region.html#method___construct",
            "name": "Modules\\Sample\\Models\\Region::__construct",
            "doc": "&quot;Region constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Modules\\Sample\\Models",
            "fromLink": "Modules/Sample/Models.html",
            "link": "Modules/Sample/Models/Subregion.html",
            "name": "Modules\\Sample\\Models\\Subregion",
            "doc": "&quot;Class Subregion&quot;"
        },
        {
            "type": "Method",
            "fromName": "Modules\\Sample\\Models\\Subregion",
            "fromLink": "Modules/Sample/Models/Subregion.html",
            "link": "Modules/Sample/Models/Subregion.html#method___construct",
            "name": "Modules\\Sample\\Models\\Subregion::__construct",
            "doc": "&quot;Subregion constructor.&quot;"
        },


        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0, -1));

        return tokens;
    }
    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function (term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function (term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function (matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function (ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function (type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function (ele) {
            ele.html(treeHtml);
        }
    };

    $(function () {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function () {

    // Enable the version switcher
    $('#version-switcher').change(function () {
        window.location = $(this).val()
    });


    // Toggle left-nav divs on click
    $('#api-tree .hd span').click(function () {
        $(this).parent().parent().toggleClass('opened');
    });

    // Expand the parent namespaces of the current page.
    var expected = $('body').attr('data-name');

    if (expected) {
        // Open the currently selected node and its parents.
        var container = $('#api-tree');
        var node = $('#api-tree li[data-name="' + expected + '"]');
        // Node might not be found when simulating namespaces
        if (node.length > 0) {
            node.addClass('active').addClass('opened');
            node.parents('li').addClass('opened');
            var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
            // Position the item nearer to the top of the screen.
            scrollPos -= 200;
            container.scrollTop(scrollPos);
        }
    }


    var form = $('#search-form .typeahead');
    form.typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'search',
        displayKey: 'name',
        source: function (q, cb) {
            cb(Sami.search(q));
        }
    });

    // The selection is direct-linked when the user selects a suggestion.
    form.on('typeahead:selected', function (e, suggestion) {
        window.location = suggestion.link;
    });

    // The form is submitted when the user hits enter.
    form.keypress(function (e) {
        if (e.which == 13) {
            $('#search-form').submit();
            return true;
        }
    });

    
});


