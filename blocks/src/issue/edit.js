/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	RichText,
	InspectorControls,
} from "@wordpress/block-editor";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

import {
	IntegerControl,
	PanelBody,
	PanelRow,
	TextControl,
} from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	const onChangeContent = (newContent) => {
		setAttributes({ content: newContent });
	};

	const setQuestion = (question) => {
		const list = JSON.parse(JSON.stringify(attributes.list));
		list[index].question = question;
		setAttributes({ question });
	};

	const setResponse = (index, response) => {
		const list = JSON.parse(JSON.stringify(attributes.list));
		list[index].response = response;
		setAttributes({ list });
	};

	const addQuestionResponse = () => {
		const list = JSON.parse(JSON.stringify(attributes.list));
		list.push({
			index: attributes.list.length,
			question: "",
			response: "",
		});
		setAttributes({ list });
	};

	return (
		<>
			{/* <InspectorControls>
				<PanelBody title="Settings" initialOpen={true}>
					<PanelRow>
						<IntegerControl
							label="Question count"
							onChange={(count) => setAttributes({ count })}
							value={attributes.count}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls> */}
			<div {...blockProps}>
				{/* <strong>{__("Questions/responses list")}</strong> */}

				{/* <RichText
								tagName="div"
								onChange={(question) =>
									setAttributes({ list: { [index]: { question } } })
								}
								allowedFormats={["core/bold", "core/italic"]}
								value={attributes.list[index].question}
								placeholder={__("❓ Write your question...")}
								className="question"
							/>
							<RichText
								tagName="div"
								onChange={(response) =>
									setAttributes({ list: { [index]: { response } } })
								}
								allowedFormats={["core/bold", "core/italic"]}
								value={attributes.list[index].response}
								placeholder={__("▶️ Write your response...")}
								className="response"
							/> */}

				<div class="wp-block-remembr-issue--question">
					❓
					<RichText
						tagName="div"
						onChange={(question) => setAttributes({ question })}
						allowedFormats={[
							"core/bold",
							"core/image",
							"core/italic",
							"core/link",
							"core/strikethrough",
							"core/text-color",
						]}
						value={attributes.question}
						placeholder={__('Question?')}
					/>
				</div>

				<div class="wp-block-remembr-issue--response">
					{/* ▶️👉➡️ */}✔️
					{/* <TextControl
									onChange={(question) => setQuestion(index, question)}
									value={attributes.list[index].question}
									placeholder={__("Question ?")}
								/> */}
					<RichText
						tagName="div"
						onChange={(response) => setAttributes({ response })}
						allowedFormats={[
							"core/bold",
							"core/image",
							"core/italic",
							"core/link",
							"core/strikethrough",
							"core/text-color",
						]}
						value={attributes.response}
						placeholder={__("Response")}
						// onKeyUp={(event) => {
						// 	if (index === attributes.list.length - 1 && "Enter" === event.key) {
						// 		addQuestionResponse()
						// 	}
						// }}
					/>
				</div>
				{/* <TextControl
					onChange={(response) => setResponse(index, response)}
					value={attributes.list[index].response}
					placeholder={__("Response ...")}
					onKeyUp={(event) => {
						if (index === attributes.list.length - 1 && "Enter" === event.key) {
							addQuestionResponse()
						}
					}}
				/> */}

				{/* <p {...blockProps}>title is {attributes.title}</p> */}
			</div>
		</>
	);
}
