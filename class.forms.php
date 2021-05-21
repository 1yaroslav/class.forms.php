<?php
//////////////////////////////////
//Класс НТМL-формы
/////////////////////////////////
class form 
{
	//Массив элементов управления
	public $fields;
	//Название кнопки НТМL-формы
	protected $button_name;
	//Класс css ячейки таблицы 
	protected $css_td_style;
	//Класс css элемента управления 
	protected $css_fld_class;
	//Стиль css элемента управления
	protected $css_fld_style;
	//конструктор класса
	public function __construct($flds,
	$button_name,
	$css_td_class = "",
	$css_td_style = "",
	$css_fld_class = "",
	$css_fld_style = "")
	{
		$this->fields = $flds;
		$this->button_name = $button_name;
		$this->css_td_class = $css_td_class;
	    $this->css_td_style = $css_td_style;
	    
	    $this->css_fld_class = $css_fld_class;
	    $this->css_fld_style = $css_fld_style;	
	    // Проверяем, являются  ли  элементы массива $flds 
	    // производными класса field
	    foreach ($flds as $key => $obj)
	    {
			if(!is_subclass_of($obj, "field"))
			{
				throw new ExceptionObject($key, "\"$key\"не является элементом управления");
			}
		}
	}
	//Вывод HTML-формы в окно браузера
	public function print_form()
	{
		$enctype = "";
		if(!empty($this->fields))
		{
			foreach($this->fields as $obj)
			{
				//назначаем всем элементам управления единый стиль
				if(!empty($this->css_fld_class))
				{
					$obj->css_class = $this->css_fld_class;
				}
				if(!empty($this->css_fld_class))
				{
					$obj->css_style = $this->css_fld_style;
				}
				//Проверяем нет ли среди элементов //управления поля file; если оно
				//есть - включаем строку
				//enctype = 'multipart/form-data'
				if($obj->type = "file")
				{
					$enctype = "enctype = 'multipart/form-data'";
				}
			}
		}
		//если елементы управления не пусты - учитываем их
		if(!empty($this->css_td_style))
		{
			$style = "style = \"".$this->css_td_style."\"";
		}
		else $style = "";
		if (!empty($this->css_td_class))
		{
			$class = "class = \"".$this->css_td_class."\"";
		}
		else $class = "";
		//Выводим HTML- форму
		echo "<form name = "form $enctype" method = "POST">";
		echo "<table>";
		if(!empty($this->fields))
		{
			forech ($this->fields as $obj)
			{
				//получаем название поля и его html-представление
				list($caption, $tag, $help, $alternative) = $obj->get_html();
				if(is_array($tag)) $tag = implode("<br>", $tag);
				echo "<tr>
				<td width = "100"
                $style $class valign = "top">$caption:</td>
                <td $style $class valign = "top">$tag</td>
                </tr>\n";
				if(!empty($help))
				{
					echo "<tr>
					<td>&nbsp;</td>
					<td $style $class valign = "top">$help</td>
					</tr>
					";
				}
			}
			//Выводим кнопку подтврерждения
			echo "<tr>
			<td $style $class></td>
			<td $style $class>
			<input class = "button" type = "submit"
			value = \"".htmlspecialchars($this->button_name, ENT_QUOTES)."\">
			</td>
			</tr>\n";
			echo "</table>";
			echo "</form>";
		}
		//перезагрузка специального метода __toString()
		public function __toString()
		{
			$this->print_form();
		}
		//Метод, проверяющий корректность ввода данных в форму
		public function check()
		{
			//Последовательно вызываем метод check 
			//для каждого объекта field,
			//принадлежащего классу
			$arr = array();
			if(!empty($this->fields))
			{
				forech($this->fields as $obj)
				{
					$str = $obj->check();
					if(!empty($str)) $arr[] = $str;
				}
			}
			return $arr;
		}
	}
?>
