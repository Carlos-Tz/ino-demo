<?php

ADOdb_Active_Record::SetDatabaseAdapter($db);

class SubRancho extends ADODB_Active_Record {
    var $_table = 'subrancho';
}

class Sector extends ADODB_Active_Record {
    var $_table = 'sector';
}

class Tuneles extends ADODB_Active_Record {
    var $_table = 'tuneles';
}

class Meteorology extends ADODB_Active_Record {
    var $_table = 'meteorological_conditions';
}

class Fenology extends ADODB_Active_Record {
    var $_table = 'phenological_stage';
}

class Tipos_Hallazgos extends ADODB_Active_Record {
    var $_table = 'tipos_hallazgo';
}

class Hallazgos extends ADODB_Active_Record {
    var $_table = 'hallazgos';
}

class Monitoreo extends ADODB_Active_Record {
    var $_table = 'monitoreo';
}

class Lectura_Monitoreo extends ADODB_Active_Record {
    var $_table = 'lectura_monitoreo';
}

class Lectura_Hallazgos extends ADODB_Active_Record {
    var $_table = 'lectura_hallazgos';
}

class Comentarios extends ADODB_Active_Record {
    var $_table = 'comentarios_lecturas';
}

ADODB_Active_Record::ClassHasMany('Monitoreo', 'lectura_monitoreo', 'id_monitoreo');