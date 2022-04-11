<?php
    // This file is part of Moodle - http://moodle.org/
    //
    // Moodle is free software: you can redistribute it and/or modify
    // it under the terms of the GNU General Public License as published by
    // the Free Software Foundation, either version 3 of the License, or
    // (at your option) any later version.
    //
    // Moodle is distributed in the hope that it will be useful,
    // but WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    // GNU General Public License for more details.
    //
    // You should have received a copy of the GNU General Public License
    // along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

    /**
     *  local_userenrols
     *
     *  This plugin will import user enrollments and group assignments
     *  from a delimited text file. It does not create new user accounts
     *  in Moodle, it will only enroll existing users in a course.
     *
     * @author      Fred Woolard <woolardfa@appstate.edu>
     * @copyright   (c) 2013 Appalachian State Universtiy, Boone, NC
     * @license     GNU General Public License version 3
     * @package     local_userenrols
     */

    defined('MOODLE_INTERNAL') || die();


    $string['pluginname']               = 'Importação de Utilizadores para Grupos';

    $string['IMPORT_MENU_LONG']         = 'Importar utilizadores para grupos';
    $string['IMPORT_MENU_SHORT']        = 'Importar';

    $string['LBL_IMPORT_TITLE']         = 'Importar Ficheiro CSV de Grupos';

    $string['LBL_IMPORT']               = 'Importar';
    $string['LBL_IDENTITY_OPTIONS']     = 'Identificação do Utilizador';
    $string['LBL_ENROLL_OPTIONS']       = 'Opções de Inscrição';
    $string['LBL_GROUP_OPTIONS']        = 'Opções de Grupo';
    $string['LBL_FILE_OPTIONS']         = 'Importação de Ficheiro';
    $string['LBL_FILE_OPTIONS_help']    = 'Carregue um ficheiro com dados de identificação do utilizador e opcionalmente com o nome do grupo. O ficheiro deverá ter extensão .txt or .csv.';
    $string['LBL_ROLE_ID']              = 'Perfil:';
    $string['LBL_ROLE_ID_help']         = 'Que perfil pretende que os utilizadores tenham no curso. Se escolhida a opção \'Sem Inscrições\' apenas serão efetuadas importações de utilizadores para grupos.';
    $string['LBL_USER_ID_FIELD']        = 'Campo de identificação do utilizador:';
    $string['LBL_USER_ID_FIELD_help']   = 'Especifique que campo de identificação do utilizador estará presente na primeira coluna do ficheiro de importação.';
    $string['LBL_GROUP']                = 'Associar a grupos:';
    $string['LBL_GROUP_help']           = 'Efetua a associação dos utilizadores aos grupos, quer seja baseado nos dados do ficheiro, quer seja de acordo com o grupo selecionado.';
    $string['LBL_GROUP_ID']             = 'Grupo a usar:';
    $string['LBL_GROUP_ID_help']        = 'Escolha usar o nome do grupo especificado no ficheiro ou escolha um grupo já existente e ignore os dados do ficheiro.';
    $string['LBL_GROUP_CREATE']         = 'Criar grupos:';
    $string['LBL_GROUP_CREATE_help']    = 'Se os grupos especificados no ficheiro de importação não existirem deverá criar os grupos, caso contrário apenas importa os utilizadores para os grupos já existentes.';
    $string['LBL_NO_ROLE_ID']           = 'Sem Inscrições';
    $string['LBL_NO_GROUP_ID']          = 'Utilizar dados do ficheiro';

    $string['VAL_NO_FILES']             = 'Não foi nenhum ficheiro selecionado para importação';
    $string['VAL_INVALID_SELECTION']    = 'Seleção inválida';
    $string['VAL_INVALID_FORM_DATA']    = 'Submissão de formulário inválida.';

    $string['INF_METACOURSE_WARN']      = '<b>WARNING</b>: You can not import enrollments directly into a metacourse. Instead, make enrollments into one of its child courses.<br /><br />';
    $string['INF_IMPORT_SUCCESS']       = 'Sucesso na inscrição de utilizadores';

    $string['ERR_NO_MANUAL_ENROL']      = "A unidade tem de ter o plugin de Inscrições Manuais ativo.";
    $string['ERR_NO_META_ENROL']        = "A unidade tem de ter o plugin 'Course meta link' ativo.";
    $string['ERR_PATTERN_MATCH']        = "Line %u: Unable to parse the line contents '%s'\n";
    $string['ERR_INVALID_GROUP_ID']     = "The group id %u is invalid for this course.\n";
    $string['ERR_USERID_INVALID']       = "Line %u: Invalid user ident value '%s'\n";
    $string['ERR_ENROLL_FAILED']        = "Line %u: Unable to create role assignment for userid '%s'\n";
    $string['ERR_ENROLL_META']          = "Line %u: No existing enrollment in metacourse for userid '%s'\n";
    $string['ERR_CREATE_GROUP']         = "Line %u: Unable to create group '%s'\n";
    $string['ERR_GROUP_MEMBER']         = "Line %u: Unable to add user '%s' to group '%s'\n";
    $string['ERR_USER_MULTIPLE_RECS']   = "Line %u: User ident value '%s' not unique. Multiple records found\n";

    $string['HELP_PAGE_IMPORT']         = 'Importação de Utilizadores para Grupos';
    $string['HELP_PAGE_IMPORT_help']    = '
<p>
Utilize este plugin para importar utilizadores a partir de um ficheiro de dados delimitados por vírgulas
para os grupos de uma unidade. Com este plugin não são criados novos utilizadores nem são realizadas novas inscrições na unidade.<br />
<br />
Se em cada linha do ficheiro especificar o nome de um grupo junto com o identificador do utilizador então o utilizador
será associado ao respetivo grupo. Se o grupo especificado ainda não existir na unidade tem a opção de criar esse grupo.
</p>

<ul>
  <li>Cada linha do ficheiro de importação representa um registo de utilizador num grupo</li>
  <li>Cada registo deverá conter a identificação do utilizador, seja o nome de utilizador, o endereço de e-mail, ou o idnumber.</li>
  <li>Cada registo poderá conter opcionalmente um campo com o nome do grupo, separado por um carater que pode ser uma vírgula, ponto e vírgual, ou tab.</li>
  <li>Evitar usar vírgulas ou pontos e vírgulas no nome dos grupos especificados, caso contrário deverá colocar o nome entre aspas</li>
  <li>Linhas em branco no ficheiro não serão interpretadas</li>
  <li>Nota: Não serão inscritos novos utilizadores na unidade.</li>
</ul>

<p>
Nas meta unidades as importações de utilizadores serão efetuadas normalmente desde que os utilizadores estejam inscritos nas unidades filhas. 
</p>

<h3>Exemplos</h3>

Idnumber e nome do grupo
<pre>
202111111;Tuesday Laborary
202111113;Wednesday Laborary
202111114;Wednesday Laborary
</pre>

Endereço de E-mail
<pre>
janedoe@university.edu, "Honors"
alan.jones@university.edu, "HonorsPlus"
</pre>

Nome de utilizador (separado do nome do grupo por um carater tab)
<pre>
202111111    "Apresentação, Group One"
202111111      Ten O\'Clock Testing
</pre>';

/*
 * GDPR compliant
 */
$string['privacy:no_data_reason'] = "O plugin 'Importação de Utilizadores para Grupos' não guarda qualquer dado pessoal do utilizador.";
