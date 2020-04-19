package de.unitrier.dbis.FunctionStoreEditor;

import com.google.gson.*;
import org.apache.jena.query.*;
import org.apache.jena.rdf.model.Model;
import org.apache.jena.rdf.model.ModelFactory;

import java.io.ByteArrayOutputStream;

public class FunctionGetter {


	String query =
			"PREFIX fs:<http://localhost/functionsstore#>\n" +
					"SELECT *\n" +
					"WHERE {\n" +
					"\t?source fs:preCondition ?preCondition .\n" +
					"\t?source fs:api ?api .\n" +
					"\t?source fs:jsonPath ?jsonPath .\n" +
					"\t?source fs:postCondition ?postCondition .\n" +
					"\t?source fs:averageResponseTime ?averageResponseTime .\n" +
					"\tOPTIONAL { " +
					"?source fs:dataAvailability ?dataAvailability . " +
					"?source fs:numberOfCalls ?numberOfCalls" +
					"}\n" +
					"}";

	String functionStoreLocation;
	Model model;

	public FunctionGetter(String functionStoreLocation) {
		model = ModelFactory.createDefaultModel();
		model.read(functionStoreLocation);
		this.functionStoreLocation = functionStoreLocation;
	}

	public FunctionDefinition[] getFunctions() {

		JsonObject queryresult = query(query);
		JsonArray functions = queryresult.getAsJsonObject("results").getAsJsonArray("bindings");
		functions = sanitizeResults(functions);

		Gson gson = new Gson();
		return gson.fromJson(functions.toString(), FunctionDefinition[].class);
	}

	private JsonArray sanitizeResults(JsonArray results) {
		for (JsonElement element : results) {
			JsonObject obj = (JsonObject) element;
			for (String key : obj.keySet()) {
				obj.add(key, obj.getAsJsonObject(key).get("value"));
			}
		}

		return results;
	}

	private JsonObject query(String queryString) {

		Query query = QueryFactory.create(queryString);
		QueryExecution queryExecution = QueryExecutionFactory.create(query, model);
		ResultSet resultSet = queryExecution.execSelect();

		ByteArrayOutputStream outputStream = new ByteArrayOutputStream();
		ResultSetFormatter.outputAsJSON(outputStream, resultSet);

		queryExecution.close();

		// return here
		return JsonParser.parseString(outputStream.toString()).getAsJsonObject();
	}

	public void close() {
		model.close();
	}
}
