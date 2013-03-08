<h1>Options</h1>
<section>
    <p>Edit option, users and then config. Create options tree.</p>
    <h2>Users:</h2>
    <p>Add | Edit | Delete</p>
    <h2>Settings:</h2>
    <div class="form">
        <form>
           <label>Save Type:</label> <select onChange="toggle(this.options[this.selectedIndex].value,false)" name="saveType">
                <option value="db">Database</option>
                <option value="ff">FlatFile</option>
            </select><br />
            <div id="db" style="display:block;">
                <label>Host:</label><input type="text" name="db[host]" /><br />
                <label>Username:</label> <input type="text" name="db[user]" /><br />
                <label>Password:</label><input type="text" name="db[pass]" /><br />
                <label>Database:</label><input type="text" name="db[database]" /><br />
                <label>Table Prefix:</label><input type="text" name="db[prefix]" /><br />
            </div>
            <div id="ff" style="display:none;">
                <label>File Path:</label><input type="text" name="ff[path]" /><br />
                <label>File Prefix:</label><input type="text" name="ff[prefix]" /><br />
            </div>
            <br />
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
</section>