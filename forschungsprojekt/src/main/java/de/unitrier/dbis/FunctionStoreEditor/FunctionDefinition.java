package de.unitrier.dbis.FunctionStoreEditor;

import java.util.UUID;

public class FunctionDefinition {
	String source;
	Integer averageResponseTime;
	String api;
	String jsonPath;
	String postCondition;
	String preCondition;

	public FunctionDefinition(String source, String preCondition, String postCondition, int averageResponseTime) {
		this.source = source;
		this.preCondition = preCondition;
		this.postCondition = postCondition;
		this.averageResponseTime = averageResponseTime;
	}

	public String insertIndividual(String url) {

		UUID postConditionId = UUID.nameUUIDFromBytes((url + postCondition).getBytes());

		return "<" + source + "> fs:api \"" + api + "\" ;\n" +
				"\tfs:averageResponseTime -1 ;\n" +
				"\tfs:dataAvailability -1.0 ;\n" +
				"\tfs:numberOfCalls -1 ;\n" +
				"\tfs:postCondition <http://localhost/f/" + postConditionId.toString() + "> ;\n" +
				"\tfs:preCondition <" + preCondition + "> ;\n" +
				"\tfs:url <" + url + "> .\n" +
				"<http://localhost/f/" + postConditionId.toString() + "> rdf:type <" + postCondition + "> ;\n" +
				"\tfs:jsonPath \"" + jsonPath + "\" ;\n" +
				"\tfs:averageResponses -1 .\n";
	}

	// Creates part of a query that represents the function as an entity with a name that can be grouped with other functions
	public String insertGrouped(String url) {
		return "<" + groupedName() + "> fs:api \"" + api + "\" ;\n" +
				"\tfs:averageResponseTime -1 ;\n" +
				"\tfs:dataAvailability -1.0 ;\n" +
				"\tfs:numberOfCalls -1 ;\n" +
				"\tfs:preCondition <" + preCondition + "> ;\n" +
				"\tfs:url <" + url + "> .\n";
	}

	// Creates paart of a query that serves to insert a post condition for a grouped function
	public String insertPost(String url){
		UUID postConditionId = UUID.nameUUIDFromBytes((url + postCondition).getBytes());

		return "<" + groupedName() + "> fs:postCondition <http://localhost/f/" + postConditionId.toString() + "> .\n" +
				"<http://localhost/f/" + postConditionId.toString() + "> rdf:type <" + postCondition + "> ;\n" +
				"\tfs:jsonPath \"" + jsonPath + "\" ;\n" +
				"\tfs:averageResponses -1 .\n";
	}

	// Consists of source_destination_precondition
	public String groupedName(){
		String[] parts = source.split("_");
		return parts[0] + "_" + parts[1] + "_" + parts[2];
	}

	@Override
	public String toString() {
		return "FunctionDefinition{" +
				"source='" + source + '\'' +
				", preCondition='" + preCondition + '\'' +
				", postCondition='" + postCondition + '\'' +
				", api='" + api + '\'' +
				", jsonPath='" + jsonPath + '\'' +
				", averageResponseTime=" + averageResponseTime +
				'}';
	}

	public String getPreCondition() {
		return preCondition;
	}
}
