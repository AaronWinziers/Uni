package de.unitrier.dbis.FunctionStoreEditor;

public class FunctionDefinition {
	String source;
	Integer averageResponseTime;
	String api;
	Double dataAvailability;
	String jsonPath;
	String postCondition;
	String preCondition;
	Integer numberOfCalls;
	Boolean requiresKey;

	public FunctionDefinition(String source, String preCondition, String postCondition, double dataAvailability, int averageResponseTime, Integer numberOfCalls) {
		this.source = source;
		this.preCondition = preCondition;
		this.postCondition = postCondition;
		this.dataAvailability = dataAvailability;
		this.averageResponseTime = averageResponseTime;
		this.numberOfCalls = numberOfCalls;
	}

	public void replaceNulls() {
		if (this.requiresKey == null) {
			this.requiresKey = this.source.contains("{key}");
		}
		if (this.numberOfCalls == null || this.dataAvailability == null || this.averageResponseTime == null
				|| this.numberOfCalls == -1 || this.dataAvailability == -1 || this.averageResponseTime == -1) {

			this.numberOfCalls = -1;
			this.averageResponseTime = -1;
			this.dataAvailability = -1.0;
		}
	}

	public String toInsert() {
		this.replaceNulls();
		String result = // If you change this DO NOT forget period at end of String (End of block in query pertaining to the ?s)
				"\t<" + source + "> fs:api \"" + api + "\" ;\n" +
						"\t\tfs:averageResponseTime " + averageResponseTime + " ;\n" +
						"\t\tfs:dataAvailability " + dataAvailability + " ;\n" +
						"\t\tfs:jsonPath \"" + jsonPath + "\" ;\n" +
						"\t\tfs:numberOfCalls " + numberOfCalls + " ;\n" +
						"\t\tfs:postCondition <" + postCondition + "> ;\n" +
						"\t\tfs:preCondition <" + preCondition + "> ;\n" +
						"\t\tfs:requiresKey " + requiresKey + " .\n";

		return result;
	}

	@Override
	public String toString() {
		return "FunctionDefinition{" +
				"source='" + source + '\'' +
				", preCondition='" + preCondition + '\'' +
				", postCondition='" + postCondition + '\'' +
				", api='" + api + '\'' +
				", jsonPath='" + jsonPath + '\'' +
				", dataAvailability=" + dataAvailability +
				", averageResponseTime=" + averageResponseTime +
				", numberOfCalls=" + numberOfCalls +
				'}';
	}
}
