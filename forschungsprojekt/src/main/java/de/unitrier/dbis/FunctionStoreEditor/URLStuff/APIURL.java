package de.unitrier.dbis.FunctionStoreEditor.URLStuff;

public class APIURL {
	String label;
	String name;
	String url;
	Parameter[] parameters;
	String format;

	public String toInsert(){
		return "\t<" + getCleanUrl() + "> fs:requiresKey \"" + url.contains("{key}") + "\" .\n";
	}

	public String getLabel() {
		return label;
	}

	public void setLabel(String label) {
		this.label = label;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getUrl() {
		return url;
	}

	public String getCleanUrl() {
		return url.replace("{","[").replace("}","]");
	}

	public void setUrl(String url) {
		this.url = url;
	}

	public Parameter[] getParameters() {
		return parameters;
	}

	public void setParameters(Parameter[] parameters) {
		this.parameters = parameters;
	}

	public String getFormat() {
		return format;
	}

	public void setFormat(String format) {
		this.format = format;
	}
}
