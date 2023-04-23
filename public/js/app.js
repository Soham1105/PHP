const classList = {
	sem2: ["CO-21", "CO-22", "CO-23", "CO-24"],
	sem4: ["CO-41", "CO-42", "CO-43", "CO-44"],
	sem6: ["CO-61", "CO-62", "CO-63", "CO-64"],
};

const subjectList = {
	"CO-21": ["211", "212", "213", "214"],
	"CO-22": ["221", "222", "223", "224"],
	"CO-23": ["231", "232", "233", "234"],
	"CO-24": ["241", "242", "243", "244"],

	"CO-41": ["411", "412", "413", "414"],
	"CO-42": ["421", "422", "423", "424"],
	"CO-43": ["431", "432", "433", "434"],
	"CO-44": ["441", "442", "443", "444"],

	"CO-61": ["611", "612", "613", "614"],
	"CO-62": ["621", "622", "623", "624"],
	"CO-63": ["631", "632", "633", "634"],
	"CO-64": ["641", "642", "643", "644"],
};

const facultyList = {
	211: ["KKR", "VPT", "KNR", "FHS", "MAS"],
	212: ["VBB", "SAS", "MGP", "HNT", "AYP", "MSB"],
	213: ["BCC", "MAS", "AYP", "SAS", "LCN"],

	221: ["KNR", "FHS", "MAS", "VPT"],
	222: ["SSD", "JAS", "SRT", "KNR", "AYP"],
	223: ["BCC", "NBA", "DVP", "ALP", "DKR"],

	231: ["SAS", "VPT", "MSB", "ASG", "BCC", "FHS"],
	232: ["LCN", "HMT", "SDS", "HVK", "AYP", "JAS"],
	233: ["BCC", "PPV", "LCN", "AYP"],

	241: ["VPT", "BCC", "DKR", "KNR", "NAP"],
	242: ["HMT", "KNR", "JAS", "HVK", "TBM", "SSD"],
	243: ["DKR", "SDS", "NBA", "BCC", "NAP"],

	411: ["ALP", "SDS", "SVM", "", "MAS", "JAS", "DVP"],
	412: ["RPV", "SVM", "VBB", "SVM", "SDS", "ALP"],
	413: ["HNT", "RSS", "ALP", "JAS", "HVK", "SDS"],

	421: ["RPV", "HVK", "JAS", "ALP", "JPS", "RSS", "HNT"],
	422: ["KNR", "RPV", "HNT", "JAS", "SVM", "ASG", "HVK"],
	423: ["ALP", "NAP", "VBB", "SDS", "HVK", "HNT", "MAS"],

	431: ["AVP", "ALP", "SVM", "JAS", "SDS", "RPV", "NAP"],
	432: ["SVM", "HNT", "JAS", "RPV", "JPS", "SVM", "SSD"],
	433: ["HVK", "JAS", "RPV", "RSS", "RPV", "JPS", "SVM"],

	441: ["SVM", "HNT", "BCC", "MAS", "VBB", "JAS", "TBM"],
	442: ["VBB", "BCC", "HNT", "RPV", "SVM", "TBM", "JAS"],

	611: ["SRT", "JAS", "ASG", "TBM", "SSD", "HNT", "ASG", "RSS"],
	612: ["TBM", "HVK", "RSS", "SRT", "DVP", "VBB", "SRT", "ASG"],
	613: ["ASG", "RSS", "TBM", "HVK", "RSS"],

	621: ["VBB", "JPS", "SSD", "DVP", "ALP"],
	622: ["JPS", "TBM", "SSD", "HNT", "JPS", "SSD", "DVP", "ALP"],
	623: ["SSD", "NAP", "DVP", "SRT", "DVP", "ALP", "MAS", "SVM"],

	631: ["HVK", "TBM", "SSD", "RPV", "JPS", "", "RSS", "NAP"],
	632: ["HNT", "MAS", "NAP", "", "RSS", "VBB", "JPS", "SRT"],
	633: ["RSS", "RPV", "SRT", "ASG", "NAP", "", "NAP", "ALP"],

	641: ["MAS", "NAP", "VBB", "SRT", "ASG", "HVK", "DVP", "SRT"],
	642: ["SRT", "HVK", "DVP", "MAS", "JPS", "SRT", "DVP"],
};

function updateClassList() {
	const semester = document.getElementById("semester").value;
	const classSelect = document.getElementById("class");
	classSelect.innerHTML = "<option value=''>Select a class</option>";
	for (const className of classList[semester]) {
		const option = document.createElement("option");
		option.value = className;
		option.text = className;
		classSelect.add(option);
	}
	updateSubjectList();
}

function updateSubjectList() {
	const className = document.getElementById("class").value;
	const subjectSelect = document.getElementById("subject");
	subjectSelect.innerHTML = "<option value=''>Select a Lab</option>";
	for (const subjectName of subjectList[className]) {
		const option = document.createElement("option");
		option.value = subjectName;
		option.text = subjectName;
		subjectSelect.add(option);
	}
	updateFacultyList();
}

function updateFacultyList() {
	const subjectName = document.getElementById("subject").value;
	const facultySelect = document.getElementById("faculty");
	facultySelect.innerHTML = "<option value=''>Select a faculty</option>";
	for (const facultyName of facultyList[subjectName]) {
		const option = document.createElement("option");
		option.value = facultyName;
		option.text = facultyName;
		facultySelect.add(option);
	}
}
