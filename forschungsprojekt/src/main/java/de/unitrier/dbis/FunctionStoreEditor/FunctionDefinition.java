package de.unitrier.dbis.FunctionStoreEditor;

import java.util.ArrayList;
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

		return "<" + source + "> fs:api \"" + api + "\" ;\n" +
				"\tfs:averageResponseTime -1 ;\n" +
				"\tfs:dataAvailability -1.0 ;\n" +
				"\tfs:numberOfCalls -1 ;\n" +
				"\tfs:preCondition <" + preCondition + "> ;\n" +
				"\tfs:url <" + url + "> .\n";
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

	// Creates part of a query that serves to insert a post condition for a grouped function
	public String insertPost(String url, String funcName) {


		// http://localhost/f/crossref_dblp_doi_publishedInJournal
		//								0			1	2		3						4
		// http://localhost/f/crossref_dblp_doi_publishedAsPartOf_publishedBy
		String[] parts = this.source.split("_");
		String subject, predicate, object;
		if (parts.length == 5) {
			if (preCondition.contains(parts[2])) {
				subject = this.preCondition;
				if (postCondition.contains(parts[3])) {
					predicate = postCondition;
					object = "https://dblp.org/rdf/schema-2017-04-18#" + parts[4];
				} else {
					predicate = "https://dblp.org/rdf/schema-2017-04-18#" + parts[3];
					object = postCondition;
				}
			} else if (preCondition.contains(parts[3])) {
				predicate = this.preCondition;
				if (postCondition.contains(parts[2])) {
					subject = postCondition;
					object = "https://dblp.org/rdf/schema-2017-04-18#" + parts[4];
				} else {
					subject = "https://dblp.org/rdf/schema-2017-04-18#" + parts[2];
					object = postCondition;
				}
			} else if (preCondition.contains(parts[4])) {
				object = this.preCondition;
				if (postCondition.contains(parts[2])) {
					subject = postCondition;
					predicate = "https://dblp.org/rdf/schema-2017-04-18#" + parts[3];
				} else {
					subject = "https://dblp.org/rdf/schema-2017-04-18#" + parts[2];
					predicate = postCondition;
				}
			} else {
				System.out.println("FunctionDefinition: Couldn't resolve SPO");
				subject = "";
				predicate = "";
				object = "";
			}
		} else if (parts.length == 4) {
			if (preCondition.contains(parts[2])) {
				subject = this.preCondition;
				predicate = this.postCondition;
				object = this.postCondition;
			} else {
				subject = this.postCondition;
				predicate = this.preCondition;
				object = this.preCondition;
			}
		} else {
			System.out.println("FunctionDefinition: Couldn't resolve SPO");
			subject = "";
			predicate = "";
			object = "";
		}
		UUID postConditionId = UUID.nameUUIDFromBytes((url+subject+predicate+object).getBytes());

		String result = "<" + funcName + "> fs:postCondition <http://localhost/f/" + postConditionId.toString() + "> .\n" +
				"<http://localhost/f/" + postConditionId.toString() + "> rdf:type <" + postCondition + "> ;\n" +
				"\tfs:jsonPath \"" + jsonPath + "\" ;\n" +
				"\tfs:averageResponses -1.0 ;\n";

		result += "fs:subject <" + subject + "> ;" +
				"fs:predicate <" + predicate + "> ;" +
				"fs:object <" + object + "> .";

		return result;
	}

	// Consists of source_destination_precondition
	public String groupedName() {
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
