window.projectVersion = 'master';

(function (root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Alxarafe" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe.html">Alxarafe</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Base" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Base.html">Base</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Base_Controller" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Base/Controller.html">Controller</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Base_PageController" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Base/PageController.html">PageController</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Base_SimpleTable" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Base/SimpleTable.html">SimpleTable</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Base_Table" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Base/Table.html">Table</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Base_View" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Base/View.html">View</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Controllers" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Controllers.html">Controllers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Controllers_EditConfig" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Controllers/EditConfig.html">EditConfig</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Controllers_ExportStructure" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Controllers/ExportStructure.html">ExportStructure</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Controllers_Login" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Controllers/Login.html">Login</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Database" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Database.html">Database</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Alxarafe_Database_Engines" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Database/Engines.html">Engines</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Database_Engines_PdoFirebird" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Database/Engines/PdoFirebird.html">PdoFirebird</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Database_Engines_PdoMySql" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Database/Engines/PdoMySql.html">PdoMySql</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Database_SqlHelpers" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Database/SqlHelpers.html">SqlHelpers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Database_SqlHelpers_SqlFirebird" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Database/SqlHelpers/SqlFirebird.html">SqlFirebird</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Database_SqlHelpers_SqlMySql" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Alxarafe/Database/SqlHelpers/SqlMySql.html">SqlMySql</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Alxarafe_Database_Engine" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Database/Engine.html">Engine</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Database_SqlHelper" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Database/SqlHelper.html">SqlHelper</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Helpers" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Helpers.html">Helpers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Helpers_Auth" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Auth.html">Auth</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Config" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Config.html">Config</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Debug" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Debug.html">Debug</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Dispatcher" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Dispatcher.html">Dispatcher</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Lang" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Lang.html">Lang</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Schema" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Schema.html">Schema</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Skin" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Skin.html">Skin</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Helpers_Utils" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Helpers/Utils.html">Utils</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Models" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Models.html">Models</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Models_Roles" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Models/Roles.html">Roles</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Models_UserRoles" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Models/UserRoles.html">UserRoles</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Models_Users" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Models/Users.html">Users</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Alxarafe_Views" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Alxarafe/Views.html">Views</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Alxarafe_Views_ConfigView" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Views/ConfigView.html">ConfigView</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Views_ExportStructureView" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Views/ExportStructureView.html">ExportStructureView</a>                    </div>                </li>                            <li data-name="class:Alxarafe_Views_LoginView" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Alxarafe/Views/LoginView.html">LoginView</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

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
            "link": "Alxarafe/Base.html",
            "name": "Alxarafe\\Base",
            "doc": "Namespace Alxarafe\\Base"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Controllers.html",
            "name": "Alxarafe\\Controllers",
            "doc": "Namespace Alxarafe\\Controllers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Database.html",
            "name": "Alxarafe\\Database",
            "doc": "Namespace Alxarafe\\Database"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Database/Engines.html",
            "name": "Alxarafe\\Database\\Engines",
            "doc": "Namespace Alxarafe\\Database\\Engines"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Database/SqlHelpers.html",
            "name": "Alxarafe\\Database\\SqlHelpers",
            "doc": "Namespace Alxarafe\\Database\\SqlHelpers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Helpers.html",
            "name": "Alxarafe\\Helpers",
            "doc": "Namespace Alxarafe\\Helpers"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Models.html",
            "name": "Alxarafe\\Models",
            "doc": "Namespace Alxarafe\\Models"
        }, {
            "type": "Namespace",
            "link": "Alxarafe/Views.html",
            "name": "Alxarafe\\Views",
            "doc": "Namespace Alxarafe\\Views"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Base",
            "fromLink": "Alxarafe/Base.html",
            "link": "Alxarafe/Base/Controller.html",
            "name": "Alxarafe\\Base\\Controller",
            "doc": "&quot;Class Controller&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Controller",
            "fromLink": "Alxarafe/Base/Controller.html",
            "link": "Alxarafe/Base/Controller.html#method___construct",
            "name": "Alxarafe\\Base\\Controller::__construct",
            "doc": "&quot;Controller constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Base",
            "fromLink": "Alxarafe/Base.html",
            "link": "Alxarafe/Base/PageController.html",
            "name": "Alxarafe\\Base\\PageController",
            "doc": "&quot;Class PageController, all controllers that needs to be accessed as a page must extends from this.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\PageController",
            "fromLink": "Alxarafe/Base/PageController.html",
            "link": "Alxarafe/Base/PageController.html#method___construct",
            "name": "Alxarafe\\Base\\PageController::__construct",
            "doc": "&quot;PageController constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\PageController",
            "fromLink": "Alxarafe/Base/PageController.html",
            "link": "Alxarafe/Base/PageController.html#method_setPageDetails",
            "name": "Alxarafe\\Base\\PageController::setPageDetails",
            "doc": "&quot;Set the page details.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\PageController",
            "fromLink": "Alxarafe/Base/PageController.html",
            "link": "Alxarafe/Base/PageController.html#method_pageDetails",
            "name": "Alxarafe\\Base\\PageController::pageDetails",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\PageController",
            "fromLink": "Alxarafe/Base/PageController.html",
            "link": "Alxarafe/Base/PageController.html#method_getPageDetails",
            "name": "Alxarafe\\Base\\PageController::getPageDetails",
            "doc": "&quot;Returns the page details as array.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Base",
            "fromLink": "Alxarafe/Base.html",
            "link": "Alxarafe/Base/SimpleTable.html",
            "name": "Alxarafe\\Base\\SimpleTable",
            "doc": "&quot;Class SimpleTable has all the basic methods to access and manipulate\ninformation, but without modifying its structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method___construct",
            "name": "Alxarafe\\Base\\SimpleTable::__construct",
            "doc": "&quot;Build a Table model. $table is the name of the table in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_setStructure",
            "name": "Alxarafe\\Base\\SimpleTable::setStructure",
            "doc": "&quot;Execute a call to setTableStructure with an array containing 3 arrays with\nthe fields, keys and default values for the table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_setTableStructure",
            "name": "Alxarafe\\Base\\SimpleTable::setTableStructure",
            "doc": "&quot;Save the structure of the table in a static array, so that it is available at all times.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getStructureArray",
            "name": "Alxarafe\\Base\\SimpleTable::getStructureArray",
            "doc": "&quot;A raw array is built with all the information available in the table, configuration files and code.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getFieldsFromTable",
            "name": "Alxarafe\\Base\\SimpleTable::getFieldsFromTable",
            "doc": "&quot;Return a list of fields and their table structure.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method___call",
            "name": "Alxarafe\\Base\\SimpleTable::__call",
            "doc": "&quot;Execute a magic method of the setField or getField style&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method___get",
            "name": "Alxarafe\\Base\\SimpleTable::__get",
            "doc": "&quot;It allows access to a field of the record using the attribute.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method___set",
            "name": "Alxarafe\\Base\\SimpleTable::__set",
            "doc": "&quot;Allows you to assign value to a field in the record using the attribute.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getIdField",
            "name": "Alxarafe\\Base\\SimpleTable::getIdField",
            "doc": "&quot;Returns the name of the main key field of the table (PK-Primary Key). By\ndefault it will be id.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_get",
            "name": "Alxarafe\\Base\\SimpleTable::get",
            "doc": "&quot;Returns a new instance of the table with the requested record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getData",
            "name": "Alxarafe\\Base\\SimpleTable::getData",
            "doc": "&quot;This method is private. Use load instead.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getTableName",
            "name": "Alxarafe\\Base\\SimpleTable::getTableName",
            "doc": "&quot;Get the name of the table (with prefix)&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_newRecord",
            "name": "Alxarafe\\Base\\SimpleTable::newRecord",
            "doc": "&quot;Sets the active record in a new record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getDataArray",
            "name": "Alxarafe\\Base\\SimpleTable::getDataArray",
            "doc": "&quot;Return an array with the current active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_load",
            "name": "Alxarafe\\Base\\SimpleTable::load",
            "doc": "&quot;Establishes a record as an active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_save",
            "name": "Alxarafe\\Base\\SimpleTable::save",
            "doc": "&quot;Saves the changes made to the active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_insertRecord",
            "name": "Alxarafe\\Base\\SimpleTable::insertRecord",
            "doc": "&quot;Insert a new record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_updateRecord",
            "name": "Alxarafe\\Base\\SimpleTable::updateRecord",
            "doc": "&quot;Update the modified fields in the active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getStructure",
            "name": "Alxarafe\\Base\\SimpleTable::getStructure",
            "doc": "&quot;Returns the structure of the normalized table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\SimpleTable",
            "fromLink": "Alxarafe/Base/SimpleTable.html",
            "link": "Alxarafe/Base/SimpleTable.html#method_getAllRecords",
            "name": "Alxarafe\\Base\\SimpleTable::getAllRecords",
            "doc": "&quot;Get an array with all data&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Base",
            "fromLink": "Alxarafe/Base.html",
            "link": "Alxarafe/Base/Table.html",
            "name": "Alxarafe\\Base\\Table",
            "doc": "&quot;Class Table allows access to a table using an active record.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method___construct",
            "name": "Alxarafe\\Base\\Table::__construct",
            "doc": "&quot;Build a Table model. $table is the name of the table in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_checkStructure",
            "name": "Alxarafe\\Base\\Table::checkStructure",
            "doc": "&quot;Create a new table if it does not exist and it has been passed true as a parameter.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getNameField",
            "name": "Alxarafe\\Base\\Table::getNameField",
            "doc": "&quot;Returns the name of the identification field of the record. By default it\nwill be name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getIdByName",
            "name": "Alxarafe\\Base\\Table::getIdByName",
            "doc": "&quot;Perform a search of a record by the name, returning the id of the\ncorresponding record, or &#039;&#039; if it is not found or does not have a\nname field.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getStructure",
            "name": "Alxarafe\\Base\\Table::getStructure",
            "doc": "&quot;Returns the structure of the normalized table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getAllRecords",
            "name": "Alxarafe\\Base\\Table::getAllRecords",
            "doc": "&quot;Get an array with all data&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getStructureArray",
            "name": "Alxarafe\\Base\\Table::getStructureArray",
            "doc": "&quot;A raw array is built with all the information available in the table, configuration files and code.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getIndexesFromTable",
            "name": "Alxarafe\\Base\\Table::getIndexesFromTable",
            "doc": "&quot;Return a list of key indexes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getDefaultValues",
            "name": "Alxarafe\\Base\\Table::getDefaultValues",
            "doc": "&quot;Return a list of default values.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\Table",
            "fromLink": "Alxarafe/Base/Table.html",
            "link": "Alxarafe/Base/Table.html#method_getChecks",
            "name": "Alxarafe\\Base\\Table::getChecks",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Base",
            "fromLink": "Alxarafe/Base.html",
            "link": "Alxarafe/Base/View.html",
            "name": "Alxarafe\\Base\\View",
            "doc": "&quot;Class View&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method___construct",
            "name": "Alxarafe\\Base\\View::__construct",
            "doc": "&quot;Load the JS and CSS files and define the ctrl, view and user variables\nfor the templates.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_addCSS",
            "name": "Alxarafe\\Base\\View::addCSS",
            "doc": "&quot;addCSS includes the common CSS files to all views templates. Also defines CSS folders templates.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_addJS",
            "name": "Alxarafe\\Base\\View::addJS",
            "doc": "&quot;addJS includes the common JS files to all views templates. Also defines JS folders templates.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method___destruct",
            "name": "Alxarafe\\Base\\View::__destruct",
            "doc": "&quot;Finally render the result.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_addResource",
            "name": "Alxarafe\\Base\\View::addResource",
            "doc": "&quot;Check if the resource is in the application&#039;s resource folder (for example, in the css or js folders\nof the skin folder). It&#039;s a specific file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_setVar",
            "name": "Alxarafe\\Base\\View::setVar",
            "doc": "&quot;Saves a value in the array that is passed to the template.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_addToVar",
            "name": "Alxarafe\\Base\\View::addToVar",
            "doc": "&quot;Add a new element to a value saved in the array that is passed to the\ntemplate.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_getVars",
            "name": "Alxarafe\\Base\\View::getVars",
            "doc": "&quot;Returns a previously saved value in the array that is passed to the\ntemplate.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_getVar",
            "name": "Alxarafe\\Base\\View::getVar",
            "doc": "&quot;Returns a previously saved value in the array that is passed to the\ntemplate.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_getErrors",
            "name": "Alxarafe\\Base\\View::getErrors",
            "doc": "&quot;Makes visible Config::getErrors() from templates, using view.getErrors()\nConfig::getErrors() returns an array with the pending error messages,\nand empties the list.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_getHeader",
            "name": "Alxarafe\\Base\\View::getHeader",
            "doc": "&quot;Returns the necessary html code in the header of the template, to\ndisplay the debug bar.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Base\\View",
            "fromLink": "Alxarafe/Base/View.html",
            "link": "Alxarafe/Base/View.html#method_getFooter",
            "name": "Alxarafe\\Base\\View::getFooter",
            "doc": "&quot;Returns the necessary html code at the footer of the template, to\ndisplay the debug bar.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Controllers",
            "fromLink": "Alxarafe/Controllers.html",
            "link": "Alxarafe/Controllers/EditConfig.html",
            "name": "Alxarafe\\Controllers\\EditConfig",
            "doc": "&quot;Controller for editing database and skin settings&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Controllers/EditConfig.html",
            "link": "Alxarafe/Controllers/EditConfig.html#method___construct",
            "name": "Alxarafe\\Controllers\\EditConfig::__construct",
            "doc": "&quot;The constructor creates the view&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Controllers/EditConfig.html",
            "link": "Alxarafe/Controllers/EditConfig.html#method_main",
            "name": "Alxarafe\\Controllers\\EditConfig::main",
            "doc": "&quot;Main is invoked if method is not specified.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Controllers/EditConfig.html",
            "link": "Alxarafe/Controllers/EditConfig.html#method_save",
            "name": "Alxarafe\\Controllers\\EditConfig::save",
            "doc": "&quot;Save the form changes in the configuration file&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\EditConfig",
            "fromLink": "Alxarafe/Controllers/EditConfig.html",
            "link": "Alxarafe/Controllers/EditConfig.html#method_pageDetails",
            "name": "Alxarafe\\Controllers\\EditConfig::pageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Controllers",
            "fromLink": "Alxarafe/Controllers.html",
            "link": "Alxarafe/Controllers/ExportStructure.html",
            "name": "Alxarafe\\Controllers\\ExportStructure",
            "doc": "&quot;Controller for editing database and skin settings&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\ExportStructure",
            "fromLink": "Alxarafe/Controllers/ExportStructure.html",
            "link": "Alxarafe/Controllers/ExportStructure.html#method___construct",
            "name": "Alxarafe\\Controllers\\ExportStructure::__construct",
            "doc": "&quot;The constructor creates the view&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\ExportStructure",
            "fromLink": "Alxarafe/Controllers/ExportStructure.html",
            "link": "Alxarafe/Controllers/ExportStructure.html#method_main",
            "name": "Alxarafe\\Controllers\\ExportStructure::main",
            "doc": "&quot;Main is invoked if method is not specified.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\ExportStructure",
            "fromLink": "Alxarafe/Controllers/ExportStructure.html",
            "link": "Alxarafe/Controllers/ExportStructure.html#method_pageDetails",
            "name": "Alxarafe\\Controllers\\ExportStructure::pageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Controllers",
            "fromLink": "Alxarafe/Controllers.html",
            "link": "Alxarafe/Controllers/Login.html",
            "name": "Alxarafe\\Controllers\\Login",
            "doc": "&quot;Class Login&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\Login",
            "fromLink": "Alxarafe/Controllers/Login.html",
            "link": "Alxarafe/Controllers/Login.html#method___construct",
            "name": "Alxarafe\\Controllers\\Login::__construct",
            "doc": "&quot;Login constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\Login",
            "fromLink": "Alxarafe/Controllers/Login.html",
            "link": "Alxarafe/Controllers/Login.html#method_main",
            "name": "Alxarafe\\Controllers\\Login::main",
            "doc": "&quot;Main is invoked if method is not specified.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\Login",
            "fromLink": "Alxarafe/Controllers/Login.html",
            "link": "Alxarafe/Controllers/Login.html#method_logout",
            "name": "Alxarafe\\Controllers\\Login::logout",
            "doc": "&quot;Close the user session and go to the main page&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Controllers\\Login",
            "fromLink": "Alxarafe/Controllers/Login.html",
            "link": "Alxarafe/Controllers/Login.html#method_pageDetails",
            "name": "Alxarafe\\Controllers\\Login::pageDetails",
            "doc": "&quot;&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Database",
            "fromLink": "Alxarafe/Database.html",
            "link": "Alxarafe/Database/Engine.html",
            "name": "Alxarafe\\Database\\Engine",
            "doc": "&quot;Engine provides generic support for databases.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method___construct",
            "name": "Alxarafe\\Database\\Engine::__construct",
            "doc": "&quot;Engine constructor&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_getEngines",
            "name": "Alxarafe\\Database\\Engine::getEngines",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_getStructure",
            "name": "Alxarafe\\Database\\Engine::getStructure",
            "doc": "&quot;Obtain an array with the table structure with a standardized format.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method___destruct",
            "name": "Alxarafe\\Database\\Engine::__destruct",
            "doc": "&quot;Engine destructor&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_rollbackTransactions",
            "name": "Alxarafe\\Database\\Engine::rollbackTransactions",
            "doc": "&quot;Undo all active transactions&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_rollBack",
            "name": "Alxarafe\\Database\\Engine::rollBack",
            "doc": "&quot;Rollback current transaction,&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_exec",
            "name": "Alxarafe\\Database\\Engine::exec",
            "doc": "&quot;Execute SQL statements on the database (INSERT, UPDATE or DELETE).&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_getLastInserted",
            "name": "Alxarafe\\Database\\Engine::getLastInserted",
            "doc": "&quot;Returns the id of the last inserted record. Failing that, it\nreturns &#039;&#039;.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_select",
            "name": "Alxarafe\\Database\\Engine::select",
            "doc": "&quot;Executes a SELECT SQL statement on the database, returning the result in an array.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_checkConnection",
            "name": "Alxarafe\\Database\\Engine::checkConnection",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_connect",
            "name": "Alxarafe\\Database\\Engine::connect",
            "doc": "&quot;Establish a connection to the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_prepare",
            "name": "Alxarafe\\Database\\Engine::prepare",
            "doc": "&quot;Prepares a statement for execution and returns a statement object\nhttp:\/\/php.net\/manual\/en\/pdo.prepare.php&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method__resultSet",
            "name": "Alxarafe\\Database\\Engine::_resultSet",
            "doc": "&quot;Returns an array containing all of the result set rows&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_execute",
            "name": "Alxarafe\\Database\\Engine::execute",
            "doc": "&quot;Executes a prepared statement\nhttp:\/\/php.net\/manual\/en\/pdostatement.execute.php&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_beginTransaction",
            "name": "Alxarafe\\Database\\Engine::beginTransaction",
            "doc": "&quot;Start transaction\nsource: https:\/\/www.ibm.com\/support\/knowledgecenter\/es\/SSEPGG_9.1.0\/com.ibm.db2.udb.apdv.php.doc\/doc\/t0023166.htm&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engine",
            "fromLink": "Alxarafe/Database/Engine.html",
            "link": "Alxarafe/Database/Engine.html#method_commit",
            "name": "Alxarafe\\Database\\Engine::commit",
            "doc": "&quot;Commit current transaction&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Database\\Engines",
            "fromLink": "Alxarafe/Database/Engines.html",
            "link": "Alxarafe/Database/Engines/PdoFirebird.html",
            "name": "Alxarafe\\Database\\Engines\\PdoFirebird",
            "doc": "&quot;Personalization of PDO to use Firebird.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engines\\PdoFirebird",
            "fromLink": "Alxarafe/Database/Engines/PdoFirebird.html",
            "link": "Alxarafe/Database/Engines/PdoFirebird.html#method___construct",
            "name": "Alxarafe\\Database\\Engines\\PdoFirebird::__construct",
            "doc": "&quot;PdoMySql constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engines\\PdoFirebird",
            "fromLink": "Alxarafe/Database/Engines/PdoFirebird.html",
            "link": "Alxarafe/Database/Engines/PdoFirebird.html#method_select",
            "name": "Alxarafe\\Database\\Engines\\PdoFirebird::select",
            "doc": "&quot;Executes a SELECT SQL statement on the database, returning the result in an array.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Database\\Engines",
            "fromLink": "Alxarafe/Database/Engines.html",
            "link": "Alxarafe/Database/Engines/PdoMySql.html",
            "name": "Alxarafe\\Database\\Engines\\PdoMySql",
            "doc": "&quot;Personalization of PDO to use MySQL.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engines\\PdoMySql",
            "fromLink": "Alxarafe/Database/Engines/PdoMySql.html",
            "link": "Alxarafe/Database/Engines/PdoMySql.html#method___construct",
            "name": "Alxarafe\\Database\\Engines\\PdoMySql::__construct",
            "doc": "&quot;PdoMySql constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\Engines\\PdoMySql",
            "fromLink": "Alxarafe/Database/Engines/PdoMySql.html",
            "link": "Alxarafe/Database/Engines/PdoMySql.html#method_connect",
            "name": "Alxarafe\\Database\\Engines\\PdoMySql::connect",
            "doc": "&quot;Connect to the database.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Database",
            "fromLink": "Alxarafe/Database.html",
            "link": "Alxarafe/Database/SqlHelper.html",
            "name": "Alxarafe\\Database\\SqlHelper",
            "doc": "&quot;Engine provides generic support for databases.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method___construct",
            "name": "Alxarafe\\Database\\SqlHelper::__construct",
            "doc": "&quot;SqlHelper constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_quoteTableName",
            "name": "Alxarafe\\Database\\SqlHelper::quoteTableName",
            "doc": "&quot;Returns the name of the table in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_quoteFieldName",
            "name": "Alxarafe\\Database\\SqlHelper::quoteFieldName",
            "doc": "&quot;Returns the name of the field in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_getTables",
            "name": "Alxarafe\\Database\\SqlHelper::getTables",
            "doc": "&quot;Returns an array with the name of all the tables in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_getColumns",
            "name": "Alxarafe\\Database\\SqlHelper::getColumns",
            "doc": "&quot;Returns an array with all the columns of a table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_getColumnsSql",
            "name": "Alxarafe\\Database\\SqlHelper::getColumnsSql",
            "doc": "&quot;SQL statement that returns the fields in the table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_normalizeFields",
            "name": "Alxarafe\\Database\\SqlHelper::normalizeFields",
            "doc": "&quot;Modifies the structure returned by the query generated with\ngetColumnsSql to the normalized format that returns getColumns&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_getIndexes",
            "name": "Alxarafe\\Database\\SqlHelper::getIndexes",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_getIndexesSql",
            "name": "Alxarafe\\Database\\SqlHelper::getIndexesSql",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_normalizeIndexes",
            "name": "Alxarafe\\Database\\SqlHelper::normalizeIndexes",
            "doc": "&quot;&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelper",
            "fromLink": "Alxarafe/Database/SqlHelper.html",
            "link": "Alxarafe/Database/SqlHelper.html#method_getConstraintsSql",
            "name": "Alxarafe\\Database\\SqlHelper::getConstraintsSql",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Database\\SqlHelpers",
            "fromLink": "Alxarafe/Database/SqlHelpers.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "doc": "&quot;Personalization of SQL queries to use Firebird.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method___construct",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::__construct",
            "doc": "&quot;SqlFirebird constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_quoteFieldName",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::quoteFieldName",
            "doc": "&quot;Returns the name of the field in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_getTables",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::getTables",
            "doc": "&quot;Returns an array with the name of all the tables in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_getColumnsSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::getColumnsSql",
            "doc": "&quot;SQL statement that returns the fields in the table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_quoteTableName",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::quoteTableName",
            "doc": "&quot;Returns the name of the table in quotes.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_normalizeFields",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::normalizeFields",
            "doc": "&quot;Modifies the structure returned by the query generated with\ngetColumnsSql to the normalized format that returns getColumns&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_normalizeIndexes",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::normalizeIndexes",
            "doc": "&quot;uniqueConstraints:\n     TC_ARTICULOS_CODIGO_U:\n         columns:\n             - CODIGOARTICULO\nindexes:\n     FK_ARTICULO_PORCENTAJEIMPUESTO:\n         columns:\n             - IDPORCENTAJEIMPUESTO&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_getIndexesSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::getIndexesSql",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_normalizeConstraints",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::normalizeConstraints",
            "doc": "&quot;&#039;TABLE_NAME&#039; =&gt; string &#039;clientes&#039; (length=8)\n&#039;COLUMN_NAME&#039; =&gt; string &#039;codgrupo&#039; (length=8)\n&#039;CONSTRAINT_NAME&#039; =&gt; string &#039;ca_clientes_grupos&#039; (length=18)\n&#039;REFERENCED_TABLE_NAME&#039; =&gt; string &#039;gruposclientes&#039; (length=14)\n&#039;REFERENCED_COLUMN_NAME&#039; =&gt; string &#039;codgrupo&#039; (length=8)&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_getViewsSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::getViewsSql",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlFirebird.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlFirebird.html#method_getConstraintsSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlFirebird::getConstraintsSql",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Database\\SqlHelpers",
            "fromLink": "Alxarafe/Database/SqlHelpers.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "doc": "&quot;Personalization of SQL queries to use MySQL.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method___construct",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::__construct",
            "doc": "&quot;SqlMySql constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getTables",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getTables",
            "doc": "&quot;Returns an array with the name of all the tables in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getColumnsSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getColumnsSql",
            "doc": "&quot;SQL statement that returns the fields in the table&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_toNativeForm",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::toNativeForm",
            "doc": "&quot;TODO: Undocummented and pending complete.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_normalizeFields",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::normalizeFields",
            "doc": "&quot;Modifies the structure returned by the query generated with\ngetColumnsSql to the normalized format that returns getColumns&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_splitType",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::splitType",
            "doc": "&quot;Divide the data type of a MySQL field into its various components: type,\nlength, unsigned or zerofill, if applicable.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_normalizeIndexes",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::normalizeIndexes",
            "doc": "&quot;Returns an array with the index information, and if there are, also constraints.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getConstraintData",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getConstraintData",
            "doc": "&quot;The data about the constraint that is found in the KEY_COLUMN_USAGE table\nis returned.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getConstraintRules",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getConstraintRules",
            "doc": "&quot;The rules for updating and deleting data with constraint (table\nREFERENTIAL_CONSTRAINTS) are returned.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getTablename",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getTablename",
            "doc": "&quot;Return the tablename or an empty string.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getIndexesSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getIndexesSql",
            "doc": "&quot;Obtain an array with the basic information about the indexes of the table,\nwhich will be supplemented with the restrictions later.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Database\\SqlHelpers\\SqlMySql",
            "fromLink": "Alxarafe/Database/SqlHelpers/SqlMySql.html",
            "link": "Alxarafe/Database/SqlHelpers/SqlMySql.html#method_getConstraintsSql",
            "name": "Alxarafe\\Database\\SqlHelpers\\SqlMySql::getConstraintsSql",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Auth.html",
            "name": "Alxarafe\\Helpers\\Auth",
            "doc": "&quot;Class Auth&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method___construct",
            "name": "Alxarafe\\Helpers\\Auth::__construct",
            "doc": "&quot;Auth constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_getCookieUser",
            "name": "Alxarafe\\Helpers\\Auth::getCookieUser",
            "doc": "&quot;TODO: Undocummented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_login",
            "name": "Alxarafe\\Helpers\\Auth::login",
            "doc": "&quot;TODO: Undocummented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_logout",
            "name": "Alxarafe\\Helpers\\Auth::logout",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_clearCookieUser",
            "name": "Alxarafe\\Helpers\\Auth::clearCookieUser",
            "doc": "&quot;TODO: Undocummented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_getUser",
            "name": "Alxarafe\\Helpers\\Auth::getUser",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_setUser",
            "name": "Alxarafe\\Helpers\\Auth::setUser",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Auth",
            "fromLink": "Alxarafe/Helpers/Auth.html",
            "link": "Alxarafe/Helpers/Auth.html#method_setCookieUser",
            "name": "Alxarafe\\Helpers\\Auth::setCookieUser",
            "doc": "&quot;Sets the cookie to the current user.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Config.html",
            "name": "Alxarafe\\Helpers\\Config",
            "doc": "&quot;All variables and global functions are centralized through the static class Config.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_configFileExists",
            "name": "Alxarafe\\Helpers\\Config::configFileExists",
            "doc": "&quot;Return true y the config file exists&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_getConfigFileName",
            "name": "Alxarafe\\Helpers\\Config::getConfigFileName",
            "doc": "&quot;Returns the name of the configuration file. By default, create the config\nfolder and enter the config.yaml file inside it.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_loadViewsConfig",
            "name": "Alxarafe\\Helpers\\Config::loadViewsConfig",
            "doc": "&quot;Set the display settings.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_getVar",
            "name": "Alxarafe\\Helpers\\Config::getVar",
            "doc": "&quot;Gets the contents of a variable. If the variable does not exist, return null.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_loadConfig",
            "name": "Alxarafe\\Helpers\\Config::loadConfig",
            "doc": "&quot;Initializes the global variable with the configuration, connects with\nthe database and authenticates the user.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_loadConfigurationFile",
            "name": "Alxarafe\\Helpers\\Config::loadConfigurationFile",
            "doc": "&quot;Returns an array with the configuration defined in the configuration file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_setError",
            "name": "Alxarafe\\Helpers\\Config::setError",
            "doc": "&quot;Register a new error message&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_connectToDatabase",
            "name": "Alxarafe\\Helpers\\Config::connectToDatabase",
            "doc": "&quot;If Config::$dbEngine contain null, create an Engine instance with the\ndatabase connection and assigns it to Config::$dbEngine.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_saveConfigFile",
            "name": "Alxarafe\\Helpers\\Config::saveConfigFile",
            "doc": "&quot;Stores all the variables in a permanent file so that they can be loaded\nlater with loadConfigFile()\nReturns true if there is no error when saving the file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_getErrors",
            "name": "Alxarafe\\Helpers\\Config::getErrors",
            "doc": "&quot;Returns an array with the pending error messages, and empties the list.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Config",
            "fromLink": "Alxarafe/Helpers/Config.html",
            "link": "Alxarafe/Helpers/Config.html#method_setVar",
            "name": "Alxarafe\\Helpers\\Config::setVar",
            "doc": "&quot;Stores a variable.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Debug.html",
            "name": "Alxarafe\\Helpers\\Debug",
            "doc": "&quot;Class Debug&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method___construct",
            "name": "Alxarafe\\Helpers\\Debug::__construct",
            "doc": "&quot;Debug constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_addException",
            "name": "Alxarafe\\Helpers\\Debug::addException",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_checkInstance",
            "name": "Alxarafe\\Helpers\\Debug::checkInstance",
            "doc": "&quot;Check if the class is instanced, and instance it if not.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_getDebugBar",
            "name": "Alxarafe\\Helpers\\Debug::getDebugBar",
            "doc": "&quot;Return the internal debug instance for get the html code.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_getRenderHeader",
            "name": "Alxarafe\\Helpers\\Debug::getRenderHeader",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_getRenderFooter",
            "name": "Alxarafe\\Helpers\\Debug::getRenderFooter",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_addMessage",
            "name": "Alxarafe\\Helpers\\Debug::addMessage",
            "doc": "&quot;Write a message in a channel (tab) of the debug bar.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_startTimer",
            "name": "Alxarafe\\Helpers\\Debug::startTimer",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_stopTimer",
            "name": "Alxarafe\\Helpers\\Debug::stopTimer",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Debug",
            "fromLink": "Alxarafe/Helpers/Debug.html",
            "link": "Alxarafe/Helpers/Debug.html#method_testArray",
            "name": "Alxarafe\\Helpers\\Debug::testArray",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Dispatcher.html",
            "name": "Alxarafe\\Helpers\\Dispatcher",
            "doc": "&quot;Class Dispatcher&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Dispatcher",
            "fromLink": "Alxarafe/Helpers/Dispatcher.html",
            "link": "Alxarafe/Helpers/Dispatcher.html#method___construct",
            "name": "Alxarafe\\Helpers\\Dispatcher::__construct",
            "doc": "&quot;Dispatcher constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Dispatcher",
            "fromLink": "Alxarafe/Helpers/Dispatcher.html",
            "link": "Alxarafe/Helpers/Dispatcher.html#method_getConfiguration",
            "name": "Alxarafe\\Helpers\\Dispatcher::getConfiguration",
            "doc": "&quot;Load the constants and the configuration file.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Dispatcher",
            "fromLink": "Alxarafe/Helpers/Dispatcher.html",
            "link": "Alxarafe/Helpers/Dispatcher.html#method_defineConstants",
            "name": "Alxarafe\\Helpers\\Dispatcher::defineConstants",
            "doc": "&quot;Define the constants of the application&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Dispatcher",
            "fromLink": "Alxarafe/Helpers/Dispatcher.html",
            "link": "Alxarafe/Helpers/Dispatcher.html#method_run",
            "name": "Alxarafe\\Helpers\\Dispatcher::run",
            "doc": "&quot;Run the application.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Dispatcher",
            "fromLink": "Alxarafe/Helpers/Dispatcher.html",
            "link": "Alxarafe/Helpers/Dispatcher.html#method_process",
            "name": "Alxarafe\\Helpers\\Dispatcher::process",
            "doc": "&quot;Walk the paths specified in $this-&gt;searchDir, trying to find the\ncontroller and method to execute.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Dispatcher",
            "fromLink": "Alxarafe/Helpers/Dispatcher.html",
            "link": "Alxarafe/Helpers/Dispatcher.html#method_processFolder",
            "name": "Alxarafe\\Helpers\\Dispatcher::processFolder",
            "doc": "&quot;Try to locate the $call class in $path, and execute the $method.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Lang.html",
            "name": "Alxarafe\\Helpers\\Lang",
            "doc": "&quot;Class Lang, give support to internationalization.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method___construct",
            "name": "Alxarafe\\Helpers\\Lang::__construct",
            "doc": "&quot;Lang constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_locateFiles",
            "name": "Alxarafe\\Helpers\\Lang::locateFiles",
            "doc": "&quot;Load the translation files following the priority system of FacturaScripts.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_getLangCode",
            "name": "Alxarafe\\Helpers\\Lang::getLangCode",
            "doc": "&quot;Returns the language code in use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_setLangCode",
            "name": "Alxarafe\\Helpers\\Lang::setLangCode",
            "doc": "&quot;Sets the language code in use.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_firstMatch",
            "name": "Alxarafe\\Helpers\\Lang::firstMatch",
            "doc": "&quot;Return first exact match, or first partial match with language key identifier,\nor it not match founded, return default language.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_getAvailableLanguages",
            "name": "Alxarafe\\Helpers\\Lang::getAvailableLanguages",
            "doc": "&quot;Returns an array with the languages with available translations.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_trans",
            "name": "Alxarafe\\Helpers\\Lang::trans",
            "doc": "&quot;Translate the text into the default language.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_customTrans",
            "name": "Alxarafe\\Helpers\\Lang::customTrans",
            "doc": "&quot;Translate the text into the selected language.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_getMissingStrings",
            "name": "Alxarafe\\Helpers\\Lang::getMissingStrings",
            "doc": "&quot;Returns the missing strings.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_getUsedStrings",
            "name": "Alxarafe\\Helpers\\Lang::getUsedStrings",
            "doc": "&quot;Returns the strings used.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Lang",
            "fromLink": "Alxarafe/Helpers/Lang.html",
            "link": "Alxarafe/Helpers/Lang.html#method_getLangFolder",
            "name": "Alxarafe\\Helpers\\Lang::getLangFolder",
            "doc": "&quot;Return the lang folder.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Schema.html",
            "name": "Alxarafe\\Helpers\\Schema",
            "doc": "&quot;The Schema class contains static methods that allow you to manipulate the\ndatabase. It is used to create and modify tables and indexes in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_saveStructure",
            "name": "Alxarafe\\Helpers\\Schema::saveStructure",
            "doc": "&quot;TODO: Undocummented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_tableExists",
            "name": "Alxarafe\\Helpers\\Schema::tableExists",
            "doc": "&quot;Return true if $tableName exists in database&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_getTables",
            "name": "Alxarafe\\Helpers\\Schema::getTables",
            "doc": "&quot;TODO: Undocumentend&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_getStructure",
            "name": "Alxarafe\\Helpers\\Schema::getStructure",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_setNormalizedStructure",
            "name": "Alxarafe\\Helpers\\Schema::setNormalizedStructure",
            "doc": "&quot;Normalize an array that has the file structure defined in the model by setStructure,\nso that it has fields with all the values it must have. Those that do not exist are\ncreated with the default value, avoiding having to do the check each time, or\ncalculating their value based on the data provided by the other fields.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_normalizeField",
            "name": "Alxarafe\\Helpers\\Schema::normalizeField",
            "doc": "&quot;Take the definition of a field, and make sure you have all the information\nthat is necessary for its creation or maintenance, calculating the missing\ndata if possible.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_createTable",
            "name": "Alxarafe\\Helpers\\Schema::createTable",
            "doc": "&quot;Create a table in the database.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_createFields",
            "name": "Alxarafe\\Helpers\\Schema::createFields",
            "doc": "&quot;Build the SQL statement to create the fields in the table.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_createIndex",
            "name": "Alxarafe\\Helpers\\Schema::createIndex",
            "doc": "&quot;Create the SQL statements for the construction of one index.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Schema",
            "fromLink": "Alxarafe/Helpers/Schema.html",
            "link": "Alxarafe/Helpers/Schema.html#method_setValues",
            "name": "Alxarafe\\Helpers\\Schema::setValues",
            "doc": "&quot;Create the SQL statements to fill the table with default data.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Skin.html",
            "name": "Alxarafe\\Helpers\\Skin",
            "doc": "&quot;Class Skin&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_setView",
            "name": "Alxarafe\\Helpers\\Skin::setView",
            "doc": "&quot;Sets the view class that will be used&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_hasTemplatesFolder",
            "name": "Alxarafe\\Helpers\\Skin::hasTemplatesFolder",
            "doc": "&quot;Return the templates folder&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_hasTemplate",
            "name": "Alxarafe\\Helpers\\Skin::hasTemplate",
            "doc": "&quot;Returns true if a template has been specified&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getSkins",
            "name": "Alxarafe\\Helpers\\Skin::getSkins",
            "doc": "&quot;Returns an array with the list of skins (folders inside the folder\nspecified for the templates)&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_setSkin",
            "name": "Alxarafe\\Helpers\\Skin::setSkin",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_setTemplate",
            "name": "Alxarafe\\Helpers\\Skin::setTemplate",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getTemplatesUri",
            "name": "Alxarafe\\Helpers\\Skin::getTemplatesUri",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getTemplatesEngine",
            "name": "Alxarafe\\Helpers\\Skin::getTemplatesEngine",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_setTemplatesEngine",
            "name": "Alxarafe\\Helpers\\Skin::setTemplatesEngine",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getCommonTemplatesUri",
            "name": "Alxarafe\\Helpers\\Skin::getCommonTemplatesUri",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_render",
            "name": "Alxarafe\\Helpers\\Skin::render",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_renderIt",
            "name": "Alxarafe\\Helpers\\Skin::renderIt",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getTemplate",
            "name": "Alxarafe\\Helpers\\Skin::getTemplate",
            "doc": "&quot;Returns the template file name.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getTemplateVars",
            "name": "Alxarafe\\Helpers\\Skin::getTemplateVars",
            "doc": "&quot;Return a list of template vars, merged with $vars,&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getOptions",
            "name": "Alxarafe\\Helpers\\Skin::getOptions",
            "doc": "&quot;Returns a list of options.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getPaths",
            "name": "Alxarafe\\Helpers\\Skin::getPaths",
            "doc": "&quot;Returns a list of available paths.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getTemplatesFolder",
            "name": "Alxarafe\\Helpers\\Skin::getTemplatesFolder",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_setTemplatesFolder",
            "name": "Alxarafe\\Helpers\\Skin::setTemplatesFolder",
            "doc": "&quot;Establish a new template. The parameter must be only de template name, no the path!&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_getCommonTemplatesFolder",
            "name": "Alxarafe\\Helpers\\Skin::getCommonTemplatesFolder",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Skin",
            "fromLink": "Alxarafe/Helpers/Skin.html",
            "link": "Alxarafe/Helpers/Skin.html#method_setCommonTemplatesFolder",
            "name": "Alxarafe\\Helpers\\Skin::setCommonTemplatesFolder",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Helpers",
            "fromLink": "Alxarafe/Helpers.html",
            "link": "Alxarafe/Helpers/Utils.html",
            "name": "Alxarafe\\Helpers\\Utils",
            "doc": "&quot;Class Utils&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Utils",
            "fromLink": "Alxarafe/Helpers/Utils.html",
            "link": "Alxarafe/Helpers/Utils.html#method_camelToSnake",
            "name": "Alxarafe\\Helpers\\Utils::camelToSnake",
            "doc": "&quot;Translate a literal in CamelCase format to snake_case format&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Utils",
            "fromLink": "Alxarafe/Helpers/Utils.html",
            "link": "Alxarafe/Helpers/Utils.html#method_snakeToCamel",
            "name": "Alxarafe\\Helpers\\Utils::snakeToCamel",
            "doc": "&quot;Translate a literal in snake_case format to CamelCase format&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Utils",
            "fromLink": "Alxarafe/Helpers/Utils.html",
            "link": "Alxarafe/Helpers/Utils.html#method_defineIfNotExists",
            "name": "Alxarafe\\Helpers\\Utils::defineIfNotExists",
            "doc": "&quot;Define a constant if it does not exist&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Helpers\\Utils",
            "fromLink": "Alxarafe/Helpers/Utils.html",
            "link": "Alxarafe/Helpers/Utils.html#method_flatArray",
            "name": "Alxarafe\\Helpers\\Utils::flatArray",
            "doc": "&quot;Flatten an array to leave it at a single level.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Models",
            "fromLink": "Alxarafe/Models.html",
            "link": "Alxarafe/Models/Roles.html",
            "name": "Alxarafe\\Models\\Roles",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\Roles",
            "fromLink": "Alxarafe/Models/Roles.html",
            "link": "Alxarafe/Models/Roles.html#method___construct",
            "name": "Alxarafe\\Models\\Roles::__construct",
            "doc": "&quot;Roles constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\Roles",
            "fromLink": "Alxarafe/Models/Roles.html",
            "link": "Alxarafe/Models/Roles.html#method_getFields",
            "name": "Alxarafe\\Models\\Roles::getFields",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\Roles",
            "fromLink": "Alxarafe/Models/Roles.html",
            "link": "Alxarafe/Models/Roles.html#method_getKeys",
            "name": "Alxarafe\\Models\\Roles::getKeys",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\Roles",
            "fromLink": "Alxarafe/Models/Roles.html",
            "link": "Alxarafe/Models/Roles.html#method_getDefaultValues",
            "name": "Alxarafe\\Models\\Roles::getDefaultValues",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Models",
            "fromLink": "Alxarafe/Models.html",
            "link": "Alxarafe/Models/UserRoles.html",
            "name": "Alxarafe\\Models\\UserRoles",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\UserRoles",
            "fromLink": "Alxarafe/Models/UserRoles.html",
            "link": "Alxarafe/Models/UserRoles.html#method___construct",
            "name": "Alxarafe\\Models\\UserRoles::__construct",
            "doc": "&quot;UserRoles constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\UserRoles",
            "fromLink": "Alxarafe/Models/UserRoles.html",
            "link": "Alxarafe/Models/UserRoles.html#method_getFields",
            "name": "Alxarafe\\Models\\UserRoles::getFields",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\UserRoles",
            "fromLink": "Alxarafe/Models/UserRoles.html",
            "link": "Alxarafe/Models/UserRoles.html#method_getKeys",
            "name": "Alxarafe\\Models\\UserRoles::getKeys",
            "doc": "&quot;TODO: Undocumented&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\UserRoles",
            "fromLink": "Alxarafe/Models/UserRoles.html",
            "link": "Alxarafe/Models/UserRoles.html#method_getDefaultValues",
            "name": "Alxarafe\\Models\\UserRoles::getDefaultValues",
            "doc": "&quot;TODO: Undocumented&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Models",
            "fromLink": "Alxarafe/Models.html",
            "link": "Alxarafe/Models/Users.html",
            "name": "Alxarafe\\Models\\Users",
            "doc": "&quot;Class Users&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Models\\Users",
            "fromLink": "Alxarafe/Models/Users.html",
            "link": "Alxarafe/Models/Users.html#method___construct",
            "name": "Alxarafe\\Models\\Users::__construct",
            "doc": "&quot;User constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Views",
            "fromLink": "Alxarafe/Views.html",
            "link": "Alxarafe/Views/ConfigView.html",
            "name": "Alxarafe\\Views\\ConfigView",
            "doc": "&quot;Class ConfigView&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Views\\ConfigView",
            "fromLink": "Alxarafe/Views/ConfigView.html",
            "link": "Alxarafe/Views/ConfigView.html#method___construct",
            "name": "Alxarafe\\Views\\ConfigView::__construct",
            "doc": "&quot;Login constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Views",
            "fromLink": "Alxarafe/Views.html",
            "link": "Alxarafe/Views/ExportStructureView.html",
            "name": "Alxarafe\\Views\\ExportStructureView",
            "doc": "&quot;Class ExportStructureView&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Views\\ExportStructureView",
            "fromLink": "Alxarafe/Views/ExportStructureView.html",
            "link": "Alxarafe/Views/ExportStructureView.html#method___construct",
            "name": "Alxarafe\\Views\\ExportStructureView::__construct",
            "doc": "&quot;ExportStructureView constructor.&quot;"
        },

        {
            "type": "Class",
            "fromName": "Alxarafe\\Views",
            "fromLink": "Alxarafe/Views.html",
            "link": "Alxarafe/Views/LoginView.html",
            "name": "Alxarafe\\Views\\LoginView",
            "doc": "&quot;Class LoginView&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Views\\LoginView",
            "fromLink": "Alxarafe/Views/LoginView.html",
            "link": "Alxarafe/Views/LoginView.html#method___construct",
            "name": "Alxarafe\\Views\\LoginView::__construct",
            "doc": "&quot;Login constructor.&quot;"
        },
        {
            "type": "Method",
            "fromName": "Alxarafe\\Views\\LoginView",
            "fromLink": "Alxarafe/Views/LoginView.html",
            "link": "Alxarafe/Views/LoginView.html#method_addCss",
            "name": "Alxarafe\\Views\\LoginView::addCss",
            "doc": "&quot;TODO: Undocummented&quot;"
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
    };

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


