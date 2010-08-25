<?php /* ////////////////////////////////////////////////////////////////////////////////
**    Copyright 2010 Matthew Burton, http://matthewburton.org
**    Code by Burton and Joshua Knowles, http://auscillate.com 
**
**    This software is part of the Open Source ACH Project (ACH). You'll find 
**    all current information about project contributors, installation, updates, 
**    bugs and more at http://competinghypotheses.org.
**
**
**    ACH is free software: you can redistribute it and/or modify
**    it under the terms of the GNU General Public License as published by
**    the Free Software Foundation, either version 3 of the License, or
**    (at your option) any later version.
**
**    ACH is distributed in the hope that it will be useful,
**    but WITHOUT ANY WARRANTY; without even the implied warranty of
**    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**    GNU General Public License for more details.
**
**    You should have received a copy of the GNU General Public License
**    along with Open Source ACH. If not, see <http://www.gnu.org/licenses/>.
//////////////////////////////////////////////////////////////////////////////// */
?>
<h3>Export Matrix</h3>

<form>

<h4>Export for printing or sharing</h4>

<p class="style2">
<label>
<input name="radiobutton" type="radio" value="radiobutton" />
</label>
Export personal matrix to GIF<br />
<input name="radiobutton" type="radio" value="radiobutton" />
Export group matrix to GIF</p>

<h4>Export for use in another ACH project</h4>

<p class="style2">
<input name="radiobutton" type="radio" value="radiobutton" />
Export personal matrix to ACHZ<br />
<input type="checkbox" name="checkbox" value="checkbox" />
Include evidence
<label></label>
<br />
<input type="checkbox" name="checkbox2" value="checkbox" />
Include hypotheses<br />

<input type="checkbox" name="checkbox3" value="checkbox" />
Include consistency scores			  </p>
<p class="style2">
<input name="radiobutton" type="radio" value="radiobutton" />
Export group matrix to ACHZ<br />
<input type="checkbox" name="checkbox4" value="checkbox" />
Include evidence<br />

<input type="checkbox" name="checkbox5" value="checkbox" />
Include hypotheses<br />
<input type="checkbox" name="checkbox6" value="checkbox" />
Include consistency scores <br />
</p>

<p class="submit"><input type="submit" name="Submit" value="Export" /></p>

</form>